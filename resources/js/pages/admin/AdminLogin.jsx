import React, { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { useAuth } from '../../context/AuthContext';
import '../../styles/admin-premium.css';

export const AdminLogin = () => {
    const navigate = useNavigate();
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const { login } = useAuth();
    const [error, setError] = useState('');
    const [isLoggingIn, setIsLoggingIn] = useState(false);

    const handleLogin = async (e) => {
        e.preventDefault();
        setError('');
        setIsLoggingIn(true);
        try {
            await login(email, password);
            navigate('/ops-7f3d');
        } catch (err) {
            console.error("Login logical failure:", err);
            setError(err.response?.data?.message || 'Authentication failed. Tactical access denied.');
        } finally {
            setIsLoggingIn(false);
        }
    };

    return (
        <div className="admin-login-layout">
            <form className="login-card" onSubmit={handleLogin}>
                <div className="login-brand">
                    <h1>Tanzania<br/>Sensational</h1>
                    <p>Admin Portal</p>
                </div>

                {error && (
                    <div className="admin-error-box" style={{ 
                        background: 'rgba(255, 68, 68, 0.1)', 
                        border: '1px solid #ff4444', 
                        color: '#ff4444', 
                        padding: '12px', 
                        borderRadius: '4px', 
                        marginBottom: '20px',
                        fontSize: '0.85rem'
                    }}>
                        {error}
                    </div>
                )}

                <div className="admin-input-group">
                    <label>Email Address</label>
                    <input 
                        type="email" 
                        value={email} 
                        onChange={(e) => setEmail(e.target.value)}
                        placeholder="admin@company.com"
                    />
                </div>

                <div className="admin-input-group">
                    <label>Password</label>
                    <input 
                        type="password" 
                        value={password} 
                        onChange={(e) => setPassword(e.target.value)}
                        placeholder="••••••••"
                    />
                </div>

                <button type="submit" className="btn-admin-primary" disabled={isLoggingIn}>
                    {isLoggingIn ? 'Signing in…' : 'Sign in'}
                </button>
            </form>
        </div>
    );
};
