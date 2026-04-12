import React, { useEffect, useMemo, useState } from 'react';
import { adminService } from '../../services/api';
import { Loader2, Plus, Save, Trash2, X } from 'lucide-react';
import '../../styles/admin-premium.css';

export const AdminUsers = () => {
    const [users, setUsers] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState('');
    const [isEditing, setIsEditing] = useState(false);
    const [saving, setSaving] = useState(false);
    const [form, setForm] = useState({
        id: null,
        name: '',
        email: '',
        role: 'manager',
        password: '',
    });

    const fetchUsers = async () => {
        setLoading(true);
        setError('');
        try {
            const res = await adminService.getUsers();
            setUsers(Array.isArray(res.data) ? res.data : []);
        } catch (e) {
            setError('Unable to load users.');
        } finally {
            setLoading(false);
        }
    };

    useEffect(() => {
        fetchUsers();
        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, []);

    const openNew = () => {
        setForm({ id: null, name: '', email: '', role: 'manager', password: '' });
        setIsEditing(true);
    };

    const openEdit = (u) => {
        setForm({ id: u.id, name: u.name, email: u.email, role: u.role || 'manager', password: '' });
        setIsEditing(true);
    };

    const onSave = async () => {
        setSaving(true);
        setError('');
        try {
            if (form.id) {
                await adminService.updateUser(form.id, {
                    name: form.name,
                    email: form.email,
                    role: form.role,
                    ...(form.password ? { password: form.password } : {}),
                });
            } else {
                await adminService.createUser({
                    name: form.name,
                    email: form.email,
                    role: form.role,
                    password: form.password,
                });
            }
            setIsEditing(false);
            await fetchUsers();
        } catch (e) {
            setError(e.response?.data?.message || 'Unable to save user.');
        } finally {
            setSaving(false);
        }
    };

    const onDelete = async (id) => {
        if (!window.confirm('Delete this user?')) return;
        try {
            await adminService.deleteUser(id);
            await fetchUsers();
        } catch (e) {
            setError(e.response?.data?.message || 'Unable to delete user.');
        }
    };

    const sorted = useMemo(() => {
        return [...users].sort((a, b) => (a.name || '').localeCompare(b.name || ''));
    }, [users]);

    return (
        <div className="admin-page-root">
            <header style={{ marginBottom: '40px' }}>
                <div style={{ display: 'flex', justifyContent: 'space-between', gap: 20, alignItems: 'flex-end' }}>
                    <div>
                        <h2 style={{ fontFamily: 'var(--font-mono)', fontSize: '0.75rem', color: 'var(--gold)', letterSpacing: '0.25em', textTransform: 'uppercase', marginBottom: '12px' }}>
                            User Management
                        </h2>
                <h1 className="admin-page-title" style={{ fontSize: '3rem', fontWeight: 300, color: 'white' }}>
                    Users
                </h1>
                    </div>
                    <button className="admin-btn-primary" onClick={openNew}>
                        <Plus size={16} /> Add user
                    </button>
                </div>
            </header>

            <div className="admin-panel shadow-premium" style={{ padding: '40px' }}>
                {error && (
                    <div className="admin-error-box" style={{ marginBottom: 20, padding: 12, border: '1px solid rgba(248,113,113,0.3)', background: 'rgba(248,113,113,0.08)', color: '#F87171' }}>
                        {error}
                    </div>
                )}

                {loading ? (
                    <div style={{ display: 'flex', alignItems: 'center', gap: 12, color: 'var(--text-dim-light)' }}>
                        <Loader2 className="animate-spin" size={18} /> Loading users…
                    </div>
                ) : (
                    <div style={{ overflowX: 'auto' }}>
                        <table className="admin-table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th style={{ width: 180 }}>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                {sorted.map((u) => (
                                    <tr key={u.id}>
                                        <td style={{ fontWeight: 600, color: 'white' }}>{u.name}</td>
                                        <td style={{ color: 'var(--text-dim-light)' }}>{u.email}</td>
                                        <td>
                                            <span className={`status-pill status-${(u.role || 'manager').toLowerCase()}`}>
                                                {(u.role || 'manager').toUpperCase()}
                                            </span>
                                        </td>
                                        <td>
                                            <div style={{ display: 'flex', gap: 10 }}>
                                                <button className="admin-btn-secondary" style={{ padding: '10px 12px' }} onClick={() => openEdit(u)}>
                                                    Edit
                                                </button>
                                                <button className="admin-btn-secondary" style={{ padding: '10px 12px', color: '#F87171' }} onClick={() => onDelete(u.id)} title="Delete">
                                                    <Trash2 size={16} />
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                ))}
                                {sorted.length === 0 && (
                                    <tr>
                                        <td colSpan={4} style={{ color: 'var(--text-dim-light)', padding: 30 }}>No users found.</td>
                                    </tr>
                                )}
                            </tbody>
                        </table>
                    </div>
                )}
            </div>

            {isEditing && (
                <div
                    role="dialog"
                    aria-modal="true"
                    style={{
                        position: 'fixed',
                        inset: 0,
                        background: 'rgba(0,0,0,0.6)',
                        display: 'grid',
                        placeItems: 'center',
                        zIndex: 2000,
                        padding: 20,
                    }}
                    onMouseDown={() => !saving && setIsEditing(false)}
                >
                    <div
                        className="admin-panel shadow-premium"
                        style={{ width: 'min(720px, 95vw)', padding: 30, background: 'var(--charcoal)' }}
                        onMouseDown={(e) => e.stopPropagation()}
                    >
                        <div style={{ display: 'flex', justifyContent: 'space-between', gap: 20, alignItems: 'flex-start', marginBottom: 20 }}>
                            <div>
                                <div style={{ fontFamily: 'var(--font-mono)', fontSize: '0.65rem', color: 'var(--gold)', letterSpacing: '0.2em', textTransform: 'uppercase' }}>
                                    {form.id ? 'Edit user' : 'Add user'}
                                </div>
                                <div style={{ fontSize: '1.6rem', color: 'white', fontWeight: 400, marginTop: 6 }}>
                                    {form.id ? form.name : 'New team member'}
                                </div>
                            </div>
                            <button onClick={() => !saving && setIsEditing(false)} style={{ background: 'none', border: 'none', color: 'rgba(255,255,255,0.4)', cursor: 'pointer' }}>
                                <X size={20} />
                            </button>
                        </div>

                        <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 16 }}>
                            <Field label="Name" value={form.name} onChange={(v) => setForm(s => ({ ...s, name: v }))} />
                            <Field label="Email" value={form.email} onChange={(v) => setForm(s => ({ ...s, email: v }))} />
                            <label style={{ display: 'grid', gap: 6 }}>
                                <span style={{ fontSize: '0.7rem', color: 'var(--text-dim-light)' }}>Role</span>
                                <select
                                    value={form.role}
                                    onChange={(e) => setForm(s => ({ ...s, role: e.target.value }))}
                                    style={{ width: '100%', background: '#0a0a0a', border: '1px solid var(--border)', padding: '10px 12px', color: 'white', fontSize: '0.9rem', outline: 'none' }}
                                >
                                    <option value="admin">Admin</option>
                                    <option value="manager">Manager</option>
                                </select>
                            </label>
                            <Field
                                label={form.id ? 'New password (optional)' : 'Password'}
                                value={form.password}
                                onChange={(v) => setForm(s => ({ ...s, password: v }))}
                                type="password"
                                placeholder={form.id ? 'Leave blank to keep unchanged' : 'Minimum 10 characters'}
                            />
                        </div>

                        <div style={{ marginTop: 20, display: 'flex', justifyContent: 'flex-end', gap: 12 }}>
                            <button className="admin-btn-secondary" onClick={() => !saving && setIsEditing(false)} disabled={saving}>
                                Cancel
                            </button>
                            <button className="admin-btn-primary" onClick={onSave} disabled={saving || !form.name || !form.email || (!form.id && !form.password)}>
                                {saving ? <Loader2 className="animate-spin" size={16} /> : <Save size={16} />} Save
                            </button>
                        </div>
                    </div>
                </div>
            )}
        </div>
    );
};

const Field = ({ label, value, onChange, type = 'text', placeholder }) => (
    <label style={{ display: 'grid', gap: 6 }}>
        <span style={{ fontSize: '0.7rem', color: 'var(--text-dim-light)' }}>{label}</span>
        <input
            value={value || ''}
            type={type}
            placeholder={placeholder}
            onChange={(e) => onChange(e.target.value)}
            style={{ width: '100%', background: '#0a0a0a', border: '1px solid var(--border)', padding: '10px 12px', color: 'white', fontSize: '0.9rem', outline: 'none' }}
        />
    </label>
);

