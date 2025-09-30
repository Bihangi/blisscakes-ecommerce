// API Client for BlissCakes Application
class ApiClient {
    constructor() {
        this.baseURL = '/api/v1';
        this.token = localStorage.getItem('auth_token');
        
        // Configure Axios defaults
        axios.defaults.baseURL = this.baseURL;
        axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
        
        if (this.token) {
            axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`;
        }

        // Add CSRF token if available
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        if (csrfToken) {
            axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken.getAttribute('content');
        }

        // Response interceptor for error handling
        axios.interceptors.response.use(
            response => response,
            error => {
                if (error.response?.status === 401) {
                    this.handleUnauthorized();
                }
                return Promise.reject(error);
            }
        );
    }

    setAuthToken(token) {
        this.token = token;
        localStorage.setItem('auth_token', token);
        axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
    }

    removeAuthToken() {
        this.token = null;
        localStorage.removeItem('auth_token');
        delete axios.defaults.headers.common['Authorization'];
    }

    handleUnauthorized() {
        this.removeAuthToken();
        window.location.href = '/login';
    }

    // Cake Management APIs
    async getCakes(params = {}) {
        try {
            const response = await axios.get('/cakes', { params });
            return response.data;
        } catch (error) {
            this.handleError(error, 'Failed to fetch cakes');
            throw error;
        }
    }

    async getCake(id) {
        try {
            const response = await axios.get(`/cakes/${id}`);
            return response.data;
        } catch (error) {
            this.handleError(error, 'Failed to fetch cake details');
            throw error;
        }
    }

    async createCake(formData) {
        try {
            const response = await axios.post('/cakes', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            });
            this.showSuccess('Cake created successfully!');
            return response.data;
        } catch (error) {
            this.handleError(error, 'Failed to create cake');
            throw error;
        }
    }

    async updateCake(id, formData) {
        try {
            const response = await axios.post(`/cakes/${id}`, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            });
            this.showSuccess('Cake updated successfully!');
            return response.data;
        } catch (error) {
            this.handleError(error, 'Failed to update cake');
            throw error;
        }
    }

    async deleteCake(id) {
        try {
            const response = await axios.delete(`/cakes/${id}`);
            this.showSuccess('Cake deleted successfully!');
            return response.data;
        } catch (error) {
            this.handleError(error, 'Failed to delete cake');
            throw error;
        }
    }

    async updateCakeStock(id, stockQuantity) {
        try {
            const response = await axios.patch(`/cakes/${id}/stock`, {
                stock_quantity: stockQuantity
            });
            this.showSuccess('Stock updated successfully!');
            return response.data;
        } catch (error) {
            this.handleError(error, 'Failed to update stock');
            throw error;
        }
    }

    async toggleCakeAvailability(id) {
        try {
            const response = await axios.patch(`/cakes/${id}/toggle-availability`);
            this.showSuccess('Availability updated successfully!');
            return response.data;
        } catch (error) {
            this.handleError(error, 'Failed to update availability');
            throw error;
        }
    }

    // Category APIs
    async getCategories() {
        try {
            const response = await axios.get('/cakes/categories');
            return response.data;
        } catch (error) {
            this.handleError(error, 'Failed to fetch categories');
            throw error;
        }
    }

    // Order Management APIs
    async getOrders(params = {}) {
        try {
            const response = await axios.get('/orders', { params });
            return response.data;
        } catch (error) {
            this.handleError(error, 'Failed to fetch orders');
            throw error;
        }
    }

    async getOrder(id) {
        try {
            const response = await axios.get(`/orders/${id}`);
            return response.data;
        } catch (error) {
            this.handleError(error, 'Failed to fetch order details');
            throw error;
        }
    }

    async updateOrderStatus(id, status) {
        try {
            const response = await axios.patch(`/orders/${id}/status`, { status });
            this.showSuccess('Order status updated successfully!');
            return response.data;
        } catch (error) {
            this.handleError(error, 'Failed to update order status');
            throw error;
        }
    }

    // Analytics APIs
    async getAnalytics(type = 'dashboard', params = {}) {
        try {
            const response = await axios.get(`/analytics/${type}`, { params });
            return response.data;
        } catch (error) {
            this.handleError(error, 'Failed to fetch analytics');
            throw error;
        }
    }

    async getUserAnalytics(userId, days = 30) {
        try {
            const response = await axios.get(`/analytics/user/${userId}`, {
                params: { days }
            });
            return response.data;
        } catch (error) {
            this.handleError(error, 'Failed to fetch user analytics');
            throw error;
        }
    }

    async getPopularProducts(limit = 10) {
        try {
            const response = await axios.get('/analytics/popular-products', {
                params: { limit }
            });
            return response.data;
        } catch (error) {
            this.handleError(error, 'Failed to fetch popular products');
            throw error;
        }
    }

    // Review APIs
    async getProductReviews(cakeId, params = {}) {
        try {
            const response = await axios.get(`/reviews/product/${cakeId}`, { params });
            return response.data;
        } catch (error) {
            this.handleError(error, 'Failed to fetch reviews');
            throw error;
        }
    }

    async createReview(data) {
        try {
            const response = await axios.post('/reviews', data);
            this.showSuccess('Review submitted successfully!');
            return response.data;
        } catch (error) {
            this.handleError(error, 'Failed to submit review');
            throw error;
        }
    }

    // Helper Methods
    handleError(error, defaultMessage = 'An error occurred') {
        let message = defaultMessage;
        
        if (error.response?.data?.message) {
            message = error.response.data.message;
        } else if (error.response?.data?.errors) {
            const errors = error.response.data.errors;
            message = Object.values(errors).flat().join(', ');
        }
        
        this.showError(message);
    }

    showSuccess(message) {
        this.showNotification(message, 'success');
    }

    showError(message) {
        this.showNotification(message, 'error');
    }

    showNotification(message, type = 'info') {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg max-w-sm transition-all duration-300 ${
            type === 'success' ? 'bg-green-500 text-white' :
            type === 'error' ? 'bg-red-500 text-white' :
            'bg-blue-500 text-white'
        }`;
        notification.innerHTML = `
            <div class="flex items-center justify-between">
                <span>${message}</span>
                <button class="ml-4 text-white hover:text-gray-200" onclick="this.parentElement.parentElement.remove()">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        `;

        document.body.appendChild(notification);

        // Auto remove after 5 seconds
        setTimeout(() => {
            if (notification.parentElement) {
                notification.remove();
            }
        }, 5000);
    }
}

// Product Management Component
class ProductManager {
    constructor() {
        this.api = new ApiClient();
        this.currentPage = 1;
        this.filters = {
            search: '',
            category: '',
            available: null
        };
        this.init();
    }

    init() {
        this.bindEvents();
        this.loadProducts();
        this.loadCategories();
    }

    bindEvents() {
        // Search functionality
        const searchInput = document.getElementById('product-search');
        if (searchInput) {
            let searchTimeout;
            searchInput.addEventListener('input', (e) => {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    this.filters.search = e.target.value;
                    this.currentPage = 1;
                    this.loadProducts();
                }, 500);
            });
        }

        // Category filter
        const categoryFilter = document.getElementById('category-filter');
        if (categoryFilter) {
            categoryFilter.addEventListener('change', (e) => {
                this.filters.category = e.target.value;
                this.currentPage = 1;
                this.loadProducts();
            });
        }

        // Form submissions
        this.bindFormEvents();
    }

    bindFormEvents() {
        // Create product form
        const createForm = document.getElementById('create-product-form');
        if (createForm) {
            createForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                await this.handleCreateProduct(e.target);
            });
        }

        // Edit product forms (delegated event handling)
        document.addEventListener('submit', async (e) => {
            if (e.target.classList.contains('edit-product-form')) {
                e.preventDefault();
                await this.handleEditProduct(e.target);
            }
        });
    }

    async loadProducts() {
        try {
            const params = {
                page: this.currentPage,
                ...this.filters
            };
            
            const response = await this.api.getCakes(params);
            this.renderProducts(response.data);
            this.renderPagination(response.pagination);
        } catch (error) {
            console.error('Error loading products:', error);
        }
    }

    async loadCategories() {
        try {
            const response = await this.api.getCategories();
            this.renderCategoryOptions(response.data);
        } catch (error) {
            console.error('Error loading categories:', error);
        }
    }

    renderProducts(products) {
        const container = document.getElementById('products-container');
        if (!container) return;

        container.innerHTML = products.map(product => `
            <div class="product-card bg-white rounded-lg shadow-md p-6" data-product-id="${product.id}">
                <div class="flex justify-between items-start mb-4">
                    <h3 class="text-lg font-semibold">${product.name}</h3>
                    <span class="px-2 py-1 text-xs rounded-full ${product.is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}">
                        ${product.is_available ? 'Available' : 'Unavailable'}
                    </span>
                </div>
                <p class="text-gray-600 mb-2">${product.description}</p>
                <p class="text-sm text-gray-500 mb-2">Category: ${product.category?.name || 'N/A'}</p>
                <p class="text-lg font-bold text-pink-600 mb-4">Rs. ${parseFloat(product.price).toFixed(2)}</p>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-500">Stock: ${product.stock_quantity || 0}</span>
                    <div class="flex space-x-2">
                        <button onclick="productManager.editProduct(${product.id})" 
                                class="bg-blue-500 text-white px-3 py-1 rounded text-sm hover:bg-blue-600">
                            Edit
                        </button>
                        <button onclick="productManager.toggleAvailability(${product.id})" 
                                class="bg-yellow-500 text-white px-3 py-1 rounded text-sm hover:bg-yellow-600">
                            Toggle
                        </button>
                        <button onclick="productManager.deleteProduct(${product.id})" 
                                class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600">
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        `).join('');
    }

    renderCategoryOptions(categories) {
        const selects = document.querySelectorAll('.category-select');
        const options = categories.map(cat => 
            `<option value="${cat.id}">${cat.name}</option>`
        ).join('');

        selects.forEach(select => {
            const currentValue = select.value;
            select.innerHTML = '<option value="">Select Category</option>' + options;
            if (currentValue) select.value = currentValue;
        });
    }

    renderPagination(pagination) {
        const container = document.getElementById('pagination-container');
        if (!container || !pagination) return;

        const { current_page, last_page } = pagination;
        let paginationHTML = '';

        if (last_page > 1) {
            paginationHTML = '<div class="flex justify-center space-x-2 mt-6">';
            
            // Previous button
            if (current_page > 1) {
                paginationHTML += `<button onclick="productManager.goToPage(${current_page - 1})" 
                    class="px-3 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Previous</button>`;
            }

            // Page numbers
            for (let i = Math.max(1, current_page - 2); i <= Math.min(last_page, current_page + 2); i++) {
                const isActive = i === current_page;
                paginationHTML += `<button onclick="productManager.goToPage(${i})" 
                    class="px-3 py-2 ${isActive ? 'bg-pink-500 text-white' : 'bg-gray-200 text-gray-700'} rounded hover:bg-pink-600">${i}</button>`;
            }

            // Next button
            if (current_page < last_page) {
                paginationHTML += `<button onclick="productManager.goToPage(${current_page + 1})" 
                    class="px-3 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Next</button>`;
            }

            paginationHTML += '</div>';
        }

        container.innerHTML = paginationHTML;
    }

    goToPage(page) {
        this.currentPage = page;
        this.loadProducts();
    }

    async handleCreateProduct(form) {
        const formData = new FormData(form);
        try {
            await this.api.createCake(formData);
            form.reset();
            this.loadProducts();
            this.closeModal('create-product-modal');
        } catch (error) {
            console.error('Error creating product:', error);
        }
    }

    async handleEditProduct(form) {
        const productId = form.dataset.productId;
        const formData = new FormData(form);
        try {
            await this.api.updateCake(productId, formData);
            this.loadProducts();
            this.closeModal('edit-product-modal');
        } catch (error) {
            console.error('Error updating product:', error);
        }
    }

    async deleteProduct(id) {
        if (!confirm('Are you sure you want to delete this product?')) return;
        
        try {
            await this.api.deleteCake(id);
            this.loadProducts();
        } catch (error) {
            console.error('Error deleting product:', error);
        }
    }

    async toggleAvailability(id) {
        try {
            await this.api.toggleCakeAvailability(id);
            this.loadProducts();
        } catch (error) {
            console.error('Error toggling availability:', error);
        }
    }

    async editProduct(id) {
        try {
            const response = await this.api.getCake(id);
            this.populateEditForm(response.data);
            this.openModal('edit-product-modal');
        } catch (error) {
            console.error('Error fetching product details:', error);
        }
    }

    populateEditForm(product) {
        const form = document.getElementById('edit-product-form');
        if (!form) return;

        form.dataset.productId = product.id;
        form.querySelector('[name="name"]').value = product.name;
        form.querySelector('[name="description"]').value = product.description;
        form.querySelector('[name="price"]').value = product.price;
        form.querySelector('[name="category_id"]').value = product.category_id;
        form.querySelector('[name="ingredients"]').value = product.ingredients || '';
        form.querySelector('[name="stock_quantity"]').value = product.stock_quantity || 0;
        form.querySelector('[name="is_available"]').checked = product.is_available;
    }

    openModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('hidden');
        }
    }

    closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.add('hidden');
        }
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Initialize product manager if on products page
    if (document.getElementById('products-container')) {
        window.productManager = new ProductManager();
    }

    // Initialize API client globally
    window.apiClient = new ApiClient();
});