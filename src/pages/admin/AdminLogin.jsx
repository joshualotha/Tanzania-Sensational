import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import '../../styles/admin-premium.css';

export const AdminLogin = () => {
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const navigate = useNavigate();

    const handleLogin = (e) => {
        e.preventDefault();
        // Mock authentication — accept any credentials
        navigate('/admin');
    };

    return (
        <div className="admin-login-layout">
            <form className="login-card" onSubmit={handleLogin}>
                <div className="login-brand">
                    <h1>Tanzania<br/>Sensational</h1>
                    <p>Expedition Command</p>
                </div>

                <div className="admin-input-group">
                    <label>Email Address</label>
                    <input 
                        type="email" 
                        value={email} 
                        onChange={(e) => setEmail(e.target.value)}
                        placeholder="operator@sensational.co.tz"
                    />
                </div>

                <div className="admin-input-group">
                    <label>Access Code</label>
                    <input 
                        type="password" 
                        value={password} 
                        onChange={(e) => setPassword(e.target.value)}
                        placeholder="••••••••"
                    />
                </div>

                <button type="submit" className="btn-admin-primary">
                    Enter Command Center
                </button>
            </form>
        </div>
    );
};
