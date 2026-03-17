import React, { useEffect, useMemo, useState } from 'react';
import { Save, Loader2 } from 'lucide-react';
import { adminService } from '../../services/api';
import '../../styles/admin-premium.css';

export const AdminSettings = () => {
    const [loading, setLoading] = useState(true);
    const [saving, setSaving] = useState(false);
    const [error, setError] = useState('');
    const [form, setForm] = useState({
        general: {
            company_name: 'Tanzania Sensational',
            tagline: '',
            currency: 'USD',
        },
        contact: {
            support_email: '',
            phone: '',
            whatsapp: '',
            address: '',
        },
        social: {
            instagram: '',
            facebook: '',
            twitter: '',
            linkedin: '',
        },
        branding: {
            primary_color: '#C9A84C',
        },
    });

    useEffect(() => {
        let mounted = true;
        const run = async () => {
            setLoading(true);
            setError('');
            try {
                const res = await adminService.getSettings();
                const settings = res.data?.settings || {};
                if (!mounted) return;
                const pick = (group, key, fallback) => settings?.[group]?.[key]?.value ?? fallback;
                setForm({
                    general: {
                        company_name: pick('general', 'company_name', form.general.company_name),
                        tagline: pick('general', 'tagline', ''),
                        currency: pick('general', 'currency', 'USD'),
                    },
                    contact: {
                        support_email: pick('contact', 'support_email', ''),
                        phone: pick('contact', 'phone', ''),
                        whatsapp: pick('contact', 'whatsapp', ''),
                        address: pick('contact', 'address', ''),
                    },
                    social: {
                        instagram: pick('social', 'instagram', ''),
                        facebook: pick('social', 'facebook', ''),
                        twitter: pick('social', 'twitter', ''),
                        linkedin: pick('social', 'linkedin', ''),
                    },
                    branding: {
                        primary_color: pick('branding', 'primary_color', '#C9A84C'),
                    },
                });
            } catch (e) {
                if (!mounted) return;
                setError('Unable to load settings.');
            } finally {
                if (!mounted) return;
                setLoading(false);
            }
        };
        run();
        return () => { mounted = false; };
        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, []);

    const payload = useMemo(() => {
        const wrap = (v) => ({ value: v });
        return {
            settings: {
                general: Object.fromEntries(Object.entries(form.general).map(([k, v]) => [k, wrap(v)])),
                contact: Object.fromEntries(Object.entries(form.contact).map(([k, v]) => [k, wrap(v)])),
                social: Object.fromEntries(Object.entries(form.social).map(([k, v]) => [k, wrap(v)])),
                branding: Object.fromEntries(Object.entries(form.branding).map(([k, v]) => [k, wrap(v)])),
            }
        };
    }, [form]);

    const onSave = async () => {
        setSaving(true);
        setError('');
        try {
            await adminService.updateSettings(payload);
        } catch (e) {
            setError(e.response?.data?.message || 'Unable to save settings.');
        } finally {
            setSaving(false);
        }
    };

    return (
        <div className="admin-page-root">
            <header style={{ marginBottom: '40px' }}>
                <h2 style={{ fontFamily: 'var(--font-mono)', fontSize: '0.75rem', color: 'var(--gold)', letterSpacing: '0.25em', textTransform: 'uppercase', marginBottom: '12px' }}>Site Configuration</h2>
                <h1 className="admin-page-title" style={{ fontSize: '3rem', fontWeight: 300, color: 'white' }}>
                    Settings
                </h1>
            </header>

            <div className="admin-panel shadow-premium" style={{ padding: '40px' }}>
                {loading ? (
                    <div style={{ display: 'flex', alignItems: 'center', gap: 12, color: 'var(--text-dim)' }}>
                        <Loader2 className="animate-spin" size={18} /> Loading settings…
                    </div>
                ) : (
                    <>
                        {error && (
                            <div className="admin-error-box" style={{ marginBottom: 20, padding: 12, border: '1px solid rgba(248,113,113,0.3)', background: 'rgba(248,113,113,0.08)', color: '#F87171' }}>
                                {error}
                            </div>
                        )}

                        <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 30 }}>
                            <Section title="Business">
                                <Field label="Company name" value={form.general.company_name} onChange={(v) => setForm(s => ({ ...s, general: { ...s.general, company_name: v } }))} />
                                <Field label="Tagline" value={form.general.tagline} onChange={(v) => setForm(s => ({ ...s, general: { ...s.general, tagline: v } }))} />
                                <Field label="Currency" value={form.general.currency} onChange={(v) => setForm(s => ({ ...s, general: { ...s.general, currency: v } }))} />
                            </Section>

                            <Section title="Contact">
                                <Field label="Support email" value={form.contact.support_email} onChange={(v) => setForm(s => ({ ...s, contact: { ...s.contact, support_email: v } }))} />
                                <Field label="Phone" value={form.contact.phone} onChange={(v) => setForm(s => ({ ...s, contact: { ...s.contact, phone: v } }))} />
                                <Field label="WhatsApp" value={form.contact.whatsapp} onChange={(v) => setForm(s => ({ ...s, contact: { ...s.contact, whatsapp: v } }))} />
                                <Field label="Address" value={form.contact.address} onChange={(v) => setForm(s => ({ ...s, contact: { ...s.contact, address: v } }))} />
                            </Section>

                            <Section title="Social">
                                <Field label="Instagram" value={form.social.instagram} onChange={(v) => setForm(s => ({ ...s, social: { ...s.social, instagram: v } }))} />
                                <Field label="Facebook" value={form.social.facebook} onChange={(v) => setForm(s => ({ ...s, social: { ...s.social, facebook: v } }))} />
                                <Field label="Twitter / X" value={form.social.twitter} onChange={(v) => setForm(s => ({ ...s, social: { ...s.social, twitter: v } }))} />
                                <Field label="LinkedIn" value={form.social.linkedin} onChange={(v) => setForm(s => ({ ...s, social: { ...s.social, linkedin: v } }))} />
                            </Section>

                            <Section title="Branding">
                                <Field label="Primary color" value={form.branding.primary_color} onChange={(v) => setForm(s => ({ ...s, branding: { ...s.branding, primary_color: v } }))} />
                            </Section>
                        </div>

                        <div style={{ marginTop: 30, display: 'flex', justifyContent: 'flex-end' }}>
                            <button className="admin-btn-primary" onClick={onSave} disabled={saving}>
                                {saving ? <Loader2 className="animate-spin" size={16} /> : <Save size={16} />} Save changes
                            </button>
                        </div>
                    </>
                )}
            </div>
        </div>
    );
};

const Section = ({ title, children }) => (
    <div style={{ border: '1px solid var(--border)', background: 'rgba(255,255,255,0.02)', padding: 20 }}>
        <div style={{ fontFamily: 'var(--font-mono)', fontSize: '0.65rem', color: 'var(--gold)', letterSpacing: '0.2em', textTransform: 'uppercase', marginBottom: 16 }}>
            {title}
        </div>
        <div style={{ display: 'grid', gap: 12 }}>
            {children}
        </div>
    </div>
);

const Field = ({ label, value, onChange }) => (
    <label style={{ display: 'grid', gap: 6 }}>
        <span style={{ fontSize: '0.7rem', color: 'var(--text-dim)' }}>{label}</span>
        <input
            value={value || ''}
            onChange={(e) => onChange(e.target.value)}
            style={{ width: '100%', background: '#0a0a0a', border: '1px solid var(--border)', padding: '10px 12px', color: 'white', fontSize: '0.9rem', outline: 'none' }}
        />
    </label>
);

