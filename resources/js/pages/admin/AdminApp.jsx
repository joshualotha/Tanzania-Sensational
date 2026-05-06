import React from 'react';
import { BrowserRouter, Routes, Route } from 'react-router-dom';
import { AuthProvider } from '../../context/AuthContext';
import { AdminLogin } from './AdminLogin';
import { AdminLayout } from './AdminLayout';
import { AdminDashboard } from './AdminDashboard';
import { AdminDestinations } from './AdminDestinations';
import { AdminSafaris } from './AdminSafaris';
import { AdminTrekking } from './AdminTrekking';
import { AdminBlog } from './AdminBlog';
import { AdminDepartures } from './AdminDepartures';
import { AdminInquiries } from './AdminInquiries';
import { AdminBookingsList } from './AdminBookingsList';
import { AdminVisuals } from './AdminVisuals';
import { AdminSettings } from './AdminSettings';
import { AdminUsers } from './AdminUsers';
import { AdminGearRequests } from './AdminGearRequests';
import { AdminPages } from './AdminPages';
import { AdminPricing } from './AdminPricing';
import { ProtectedRoute } from '../../components/auth/ProtectedRoute';

const AdminApp = () => {
    return (
        <BrowserRouter>
            <AuthProvider>
                <Routes>
                    <Route path="/ops-7f3d/login" element={<AdminLogin />} />
                    <Route element={<ProtectedRoute />}>
                        <Route path="/ops-7f3d" element={<AdminLayout />}>
                            <Route index element={<AdminDashboard />} />
                            <Route path="destinations" element={<AdminDestinations />} />
                            <Route path="safaris" element={<AdminSafaris />} />
                            <Route path="trekking" element={<AdminTrekking />} />
                            <Route path="blog" element={<AdminBlog />} />
                            <Route path="departures" element={<AdminDepartures />} />
                            <Route path="inquiries" element={<AdminInquiries />} />
                            <Route path="bookings" element={<AdminBookingsList />} />
                            <Route path="visuals" element={<AdminVisuals />} />
                            <Route path="settings" element={<AdminSettings />} />
                            <Route path="users" element={<AdminUsers />} />
                            <Route path="gear-requests" element={<AdminGearRequests />} />
                            <Route path="pages" element={<AdminPages />} />
                            <Route path="pricing" element={<AdminPricing />} />
                        </Route>
                    </Route>
                </Routes>
            </AuthProvider>
        </BrowserRouter>
    );
};

export default AdminApp;
