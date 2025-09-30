<?php

namespace App\Services;

use MongoDB\Client;
use MongoDB\Collection;
use Illuminate\Support\Facades\Log;

class MongoDBService
{
    private Client $client;
    private Collection $analyticsCollection;
    private Collection $logsCollection;
    private Collection $reviewsCollection;

    public function __construct()
    {
        $this->client = new Client(env('MONGODB_URI', 'mongodb://localhost:27017'));
        $database = $this->client->selectDatabase(env('MONGODB_DATABASE', 'blisscakes_analytics'));
        
        $this->analyticsCollection = $database->selectCollection('user_analytics');
        $this->logsCollection = $database->selectCollection('system_logs');
        $this->reviewsCollection = $database->selectCollection('product_reviews');
    }

    /**
     * Log user activity for analytics
     */
    public function logUserActivity($userId, $activity, $details = [])
    {
        try {
            $document = [
                'user_id' => $userId,
                'activity' => $activity,
                'details' => $details,
                'timestamp' => new \DateTime(),
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'session_id' => session()->getId()
            ];

            $this->analyticsCollection->insertOne($document);
            return true;
        } catch (\Exception $e) {
            Log::error('MongoDB Analytics Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Log system events
     */
    public function logSystemEvent($event, $level = 'info', $data = [])
    {
        try {
            $document = [
                'event' => $event,
                'level' => $level,
                'data' => $data,
                'timestamp' => new \DateTime(),
                'server' => gethostname(),
                'environment' => app()->environment()
            ];

            $this->logsCollection->insertOne($document);
            return true;
        } catch (\Exception $e) {
            Log::error('MongoDB Logging Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Store product review
     */
    public function storeReview($userId, $cakeId, $rating, $comment, $orderItemId = null)
    {
        try {
            $document = [
                'user_id' => $userId,
                'cake_id' => $cakeId,
                'order_item_id' => $orderItemId,
                'rating' => $rating,
                'comment' => $comment,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),
                'status' => 'approved', // or 'pending' for moderation
                'helpful_votes' => 0
            ];

            $result = $this->reviewsCollection->insertOne($document);
            return $result->getInsertedId();
        } catch (\Exception $e) {
            Log::error('MongoDB Review Storage Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get user activity analytics
     */
    public function getUserAnalytics($userId, $days = 30)
    {
        try {
            $startDate = new \DateTime();
            $startDate->modify("-{$days} days");

            $pipeline = [
                [
                    '$match' => [
                        'user_id' => $userId,
                        'timestamp' => ['$gte' => $startDate]
                    ]
                ],
                [
                    '$group' => [
                        '_id' => '$activity',
                        'count' => ['$sum' => 1],
                        'last_activity' => ['$max' => '$timestamp']
                    ]
                ],
                ['$sort' => ['count' => -1]]
            ];

            return $this->analyticsCollection->aggregate($pipeline)->toArray();
        } catch (\Exception $e) {
            Log::error('MongoDB Analytics Retrieval Error: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Get popular products analytics
     */
    public function getPopularProducts($limit = 10)
    {
        try {
            $pipeline = [
                [
                    '$match' => [
                        'activity' => 'product_view',
                        'timestamp' => [
                            '$gte' => new \DateTime('-30 days')
                        ]
                    ]
                ],
                [
                    '$group' => [
                        '_id' => '$details.cake_id',
                        'views' => ['$sum' => 1],
                        'unique_users' => ['$addToSet' => '$user_id']
                    ]
                ],
                [
                    '$addFields' => [
                        'unique_user_count' => ['$size' => '$unique_users']
                    ]
                ],
                ['$sort' => ['views' => -1]],
                ['$limit' => $limit]
            ];

            return $this->analyticsCollection->aggregate($pipeline)->toArray();
        } catch (\Exception $e) {
            Log::error('MongoDB Popular Products Error: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Get product reviews
     */
    public function getProductReviews($cakeId, $limit = 20, $skip = 0)
    {
        try {
            return $this->reviewsCollection
                ->find(
                    ['cake_id' => $cakeId, 'status' => 'approved'],
                    [
                        'sort' => ['created_at' => -1],
                        'limit' => $limit,
                        'skip' => $skip
                    ]
                )
                ->toArray();
        } catch (\Exception $e) {
            Log::error('MongoDB Reviews Error: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Get average rating for a product
     */
    public function getAverageRating($cakeId)
    {
        try {
            $pipeline = [
                [
                    '$match' => [
                        'cake_id' => $cakeId,
                        'status' => 'approved'
                    ]
                ],
                [
                    '$group' => [
                        '_id' => null,
                        'average_rating' => ['$avg' => '$rating'],
                        'total_reviews' => ['$sum' => 1]
                    ]
                ]
            ];

            $result = $this->reviewsCollection->aggregate($pipeline)->toArray();
            return $result[0] ?? ['average_rating' => 0, 'total_reviews' => 0];
        } catch (\Exception $e) {
            Log::error('MongoDB Rating Error: ' . $e->getMessage());
            return ['average_rating' => 0, 'total_reviews' => 0];
        }
    }

    /**
     * Get system analytics dashboard data
     */
    public function getSystemAnalytics($days = 7)
    {
        try {
            $startDate = new \DateTime();
            $startDate->modify("-{$days} days");

            $pipeline = [
                [
                    '$match' => [
                        'timestamp' => ['$gte' => $startDate]
                    ]
                ],
                [
                    '$group' => [
                        '_id' => [
                            'date' => [
                                '$dateToString' => [
                                    'format' => '%Y-%m-%d',
                                    'date' => '$timestamp'
                                ]
                            ],
                            'activity' => '$activity'
                        ],
                        'count' => ['$sum' => 1]
                    ]
                ],
                [
                    '$group' => [
                        '_id' => '$_id.date',
                        'activities' => [
                            '$push' => [
                                'activity' => '$_id.activity',
                                'count' => '$count'
                            ]
                        ],
                        'total_activities' => ['$sum' => '$count']
                    ]
                ],
                ['$sort' => ['_id' => 1]]
            ];

            return $this->analyticsCollection->aggregate($pipeline)->toArray();
        } catch (\Exception $e) {
            Log::error('MongoDB System Analytics Error: ' . $e->getMessage());
            return [];
        }
    }
}