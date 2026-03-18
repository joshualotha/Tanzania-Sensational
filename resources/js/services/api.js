import axios from 'axios';

let csrfPromise = null;
async function ensureCsrfCookie() {
    if (!csrfPromise) {
        csrfPromise = axios.get('/sanctum/csrf-cookie').catch((e) => {
            csrfPromise = null;
            throw e;
        });
    }
    return csrfPromise;
}

export const api = axios.create({
    baseURL: '/api',
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
    },
    withCredentials: true,
    withXSRFToken: true,
    xsrfCookieName: 'XSRF-TOKEN',
    xsrfHeaderName: 'X-XSRF-TOKEN',
});

// For session-based CSRF, prefer the XSRF-TOKEN cookie (not the meta tag),
// because the session/CSRF token can rotate after login without a full page reload.
api.interceptors.request.use(async (config) => {
    const method = String(config.method || 'get').toLowerCase();
    const isMutating = ['post', 'put', 'patch', 'delete'].includes(method);
    if (isMutating) {
        await ensureCsrfCookie();
    }
    return config;
});

// If the session/CSRF token rotated (common after idle), refresh and retry once.
api.interceptors.response.use(
    (res) => res,
    async (error) => {
        const status = error?.response?.status;
        const config = error?.config;
        if (status === 419 && config && !config.__retried419) {
            config.__retried419 = true;
            csrfPromise = null;
            await ensureCsrfCookie();
            return api.request(config);
        }
        throw error;
    }
);

// If the session/CSRF token rotated (common after idle), refresh and retry once.
api.interceptors.response.use(
    (res) => res,
    async (error) => {
        const status = error?.response?.status;
        const config = error?.config;
        if (status === 419 && config && !config.__retried419) {
            config.__retried419 = true;
            csrfPromise = null;
            await ensureCsrfCookie();
            return api.request(config);
        }
        throw error;
    }
);

// Auth service
export const authService = {
    getCsrfCookie: () => ensureCsrfCookie(),
    login: (email, password) => api.post('/login', { email, password }),
    logout: () => api.post('/logout'),
    getUser: () => api.get('/user'),
};

// Public data services
export const trekkingService = {
    getAll: () => api.get('/trekking-routes'),
    getBySlug: (slug) => api.get(`/trekking-routes/${slug}`),
    getById: (id) => api.get(`/trekking-routes/${id}`),
};

export const contactService = {
    submit: (data) => api.post('/contact', data),
};

export const departureService = {
    getAll: (params = {}) => api.get('/departures', { params }),
    getById: (id) => api.get(`/departures/${id}`),
};

export const safariService = {
    getAll: () => api.get('/safari-packages'),
    getBySlug: (slug) => api.get(`/safari-packages/${slug}`),
    getById: (id) => api.get(`/safari-packages/${id}`),
};

export const destinationService = {
    getAll: () => api.get('/destinations'),
    getBySlug: (slug) => api.get(`/destinations/${slug}`),
    getById: (id) => api.get(`/destinations/${id}`),
};

export const bookingService = {
    create: (data) => api.post('/bookings', data),
    createSafariBooking: (data) => api.post('/bookings/safari', data),
};

export const gearService = {
    getItems: () => api.get('/gear-items'),
    requestRental: (data) => api.post('/gear-rental-requests', data),
};

export const blogService = {
    getAll: () => api.get('/blog'),
    getBySlug: (slug) => api.get(`/blog/${slug}`),
};

export const pageService = {
    getBySlug: (slug) => api.get(`/pages/${slug}`),
};

export const adminService = {
    getStats: () => api.get('/stats'),
    
    // Safaris
    getSafaris: () => api.get('/safari-packages'),
    createSafari: (data) => api.post('/admin/safari-packages', data),
    updateSafari: (id, data) => api.put(`/admin/safari-packages/${id}`, data),
    deleteSafari: (id) => api.delete(`/admin/safari-packages/${id}`),
    
    // Trekking
    getTrekking: () => api.get('/trekking-routes'),
    createTrekking: (data) => api.post('/admin/trekking-routes', data),
    updateTrekking: (id, data) => api.put(`/admin/trekking-routes/${id}`, data),
    deleteTrekking: (id) => api.delete(`/admin/trekking-routes/${id}`),

    // Destinations
    getDestinations: () => api.get('/destinations'),
    createDestination: (data) => api.post('/admin/destinations', data),
    updateDestination: (id, data) => api.put(`/admin/destinations/${id}`, data),
    deleteDestination: (id) => api.delete(`/admin/destinations/${id}`),
    
    // Blog
    getBlogPosts: () => api.get('/admin/blog'),
    createBlogPost: (data) => api.post('/admin/blog', data),
    updateBlogPost: (id, data) => api.put(`/admin/blog/${id}`, data),
    deleteBlogPost: (id) => api.delete(`/admin/blog/${id}`),

    // Departures
    getDepartures: () => api.get('/departures'),
    createDeparture: (data) => api.post('/admin/departures', data),
    updateDeparture: (id, data) => api.put(`/admin/departures/${id}`, data),
    deleteDeparture: (id) => api.delete(`/admin/departures/${id}`),

    // Bookings
    getBookings: () => api.get('/admin/bookings'),
    updateBookingStatus: (id, status) => api.put(`/admin/bookings/${id}`, { status }),
    deleteBooking: (id) => api.delete(`/admin/bookings/${id}`),
    replyToBooking: (id, data) => api.post(`/admin/bookings/${id}/reply`, data),

    // Inquiries
    getInquiries: () => api.get('/admin/inquiries'),
    deleteInquiry: (id) => api.delete(`/admin/inquiries/${id}`),

    // Settings
    getSettings: () => api.get('/admin/settings'),
    updateSettings: (payload) => api.put('/admin/settings', payload),

    // Users
    getUsers: () => api.get('/admin/users'),
    createUser: (data) => api.post('/admin/users', data),
    updateUser: (id, data) => api.put(`/admin/users/${id}`, data),
    deleteUser: (id) => api.delete(`/admin/users/${id}`),

    // Gear rental requests
    getGearRentalRequests: () => api.get('/admin/gear-rental-requests'),
    updateGearRentalRequestStatus: (id, status) => api.put(`/admin/gear-rental-requests/${id}`, { status }),

    // CMS pages
    getPages: () => api.get('/admin/pages'),
    createPage: (data) => api.post('/admin/pages', data),
    updatePage: (slug, data) => api.put(`/admin/pages/${slug}`, data),

    // Pricing rules (private trek calculator)
    getPricingRules: (trekking_route_id = null) => api.get('/admin/pricing-rules', { params: trekking_route_id ? { trekking_route_id } : {} }),
    createPricingRule: (data) => api.post('/admin/pricing-rules', data),
    updatePricingRule: (id, data) => api.put(`/admin/pricing-rules/${id}`, data),
    deletePricingRule: (id) => api.delete(`/admin/pricing-rules/${id}`),

    // Uploads
    upload: (file, folder = 'uploads') => {
        const form = new FormData();
        form.append('file', file);
        form.append('folder', folder);
        return api.post('/admin/uploads', form, { headers: { 'Content-Type': 'multipart/form-data' } });
    },

    // Notifications
    getNotifications: (params = {}) => api.get('/admin/notifications', { params }),
    markNotificationRead: (id) => api.post(`/admin/notifications/${id}/read`),
    markAllNotificationsRead: () => api.post('/admin/notifications/read-all'),
};

export const visualAssetService = {
    getAll: (config = {}) => api.get('/visual-assets', config),
    getByKey: (key) => api.get(`/visual-assets/${key}`),
    adminGetAll: (config = {}) => api.get('/admin/visual-assets', config),
    adminUpdate: (key, data) => api.put(`/admin/visual-assets/${key}`, data),
    adminCreate: (data) => api.post('/admin/visual-assets', data),
    adminDelete: (key, config = {}) => api.delete(`/admin/visual-assets/${key}`, config),
};

export default api;
