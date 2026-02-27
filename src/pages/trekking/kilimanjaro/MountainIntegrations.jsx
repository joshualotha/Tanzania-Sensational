import React, { useState, useEffect } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import { ResponsiveContainer, AreaChart, XAxis, YAxis, Tooltip, ReferenceArea, Area } from 'recharts';

/**
 * ElevationGraph - A robust mountain profile graph
 */
export const ElevationGraph = ({ data, compact = false }) => {
    if (!data || data.length === 0) return (
        <div style={{ height: compact ? '300px' : '400px', display: 'flex', alignItems: 'center', justifyContent: 'center', backgroundColor: '#f9f9f9', border: '1px dashed #ccc' }}>
            <p style={{ color: '#888', fontFamily: 'Inter' }}>Acquiring mountain telemetry...</p>
        </div>
    );

    return (
        <div style={{
            width: '100%',
            overflowX: 'auto',
            WebkitOverflowScrolling: 'touch',
            backgroundColor: '#fff',
            padding: compact ? '20px' : '60px 40px',
            border: '1px solid var(--lux-border)',
            boxShadow: compact ? 'none' : '0 30px 60px rgba(0,0,0,0.05)',
            borderRadius: '2px'
        }}>
            <div style={{ minWidth: compact ? '500px' : '1000px' }}>
                <AreaChart width={compact ? 700 : 1200} height={compact ? 300 : 500} data={data} margin={{ top: 20, right: 30, left: 10, bottom: 20 }}>
                    <defs>
                        <linearGradient id="mountGradient" x1="0" y1="0" x2="0" y2="1">
                            <stop offset="5%" stopColor="#8b6b4d" stopOpacity={0.8} />
                            <stop offset="95%" stopColor="#8b6b4d" stopOpacity={0.1} />
                        </linearGradient>
                        <filter id="shadow" height="200%">
                            <feGaussianBlur in="SourceAlpha" stdDeviation="3" />
                            <feOffset dx="0" dy="4" result="offsetblur" />
                            <feComponentTransfer>
                                <feFuncA type="linear" slope="0.5" />
                            </feComponentTransfer>
                            <feMerge>
                                <feMergeNode />
                                <feMergeNode in="SourceGraphic" />
                            </feMerge>
                        </filter>
                    </defs>

                    {/* Technical Grid */}
                    <XAxis
                        dataKey="name"
                        axisLine={{ stroke: '#eee' }}
                        tickLine={false}
                        tick={{ fontSize: 12, fill: '#666', fontFamily: 'Inter', fontWeight: 500 }}
                        dy={10}
                    />
                    <YAxis
                        axisLine={{ stroke: '#eee' }}
                        tickLine={false}
                        tick={{ fontSize: 11, fill: '#888', fontFamily: 'Inter' }}
                        unit="m"
                        domain={[0, 6000]}
                    />

                    <Tooltip
                        cursor={{ stroke: '#8b6b4d', strokeWidth: 1, strokeDasharray: '3 3' }}
                        content={({ active, payload }) => {
                            if (active && payload && payload.length) {
                                return (
                                    <div style={{ backgroundColor: '#1a1a1a', color: '#fff', padding: '15px', border: 'none', borderRadius: '0px', boxShadow: '0 10px 30px rgba(0,0,0,0.2)' }}>
                                        <p style={{ margin: 0, fontSize: '10px', color: '#8b6b4d', textTransform: 'uppercase', letterSpacing: '1px' }}>{payload[0].payload.name}</p>
                                        <p style={{ margin: '5px 0', fontSize: '18px', fontFamily: 'Playfair Display' }}>{payload[0].value}m</p>
                                        <p style={{ margin: 0, fontSize: '12px', opacity: 0.7 }}>{payload[0].payload.camp}</p>
                                    </div>
                                );
                            }
                            return null;
                        }}
                    />

                    {/* Ecological Zones Shading */}
                    <ReferenceArea y1={0} y2={2800} fill="#2e7d32" fillOpacity={0.03} />
                    <ReferenceArea y1={2800} y2={4000} fill="#fdd835" fillOpacity={0.03} />
                    <ReferenceArea y1={4000} y2={5000} fill="#757575" fillOpacity={0.05} />
                    <ReferenceArea y1={5000} y2={6000} fill="#e1f5fe" fillOpacity={0.1} />

                    <Area
                        type="monotone"
                        dataKey="elevation"
                        stroke="#8b6b4d"
                        strokeWidth={4}
                        fill="url(#mountGradient)"
                        animationDuration={1500}
                        dot={{ r: 5, fill: '#fff', stroke: '#8b6b4d', strokeWidth: 2 }}
                        activeDot={{ r: 9, fill: '#8b6b4d', stroke: '#fff', strokeWidth: 2 }}
                    />
                </AreaChart>
            </div>
        </div>
    );
};

/**
 * LiveWeatherWidget - A high-fidelity "Live" weather station
 */
export const LiveWeatherWidget = ({ zone = "Rainforest", compact = false }) => {
    const [weather, setWeather] = useState(null);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        // Simulating a real API fetch for Kilimanjaro
        const timer = setTimeout(() => {
            setWeather({
                "Rainforest": { temp: "22°C", condition: "Tropical Rain", humidity: "92%", wind: "12 km/h", icon: "🌧️" },
                "Moorland": { temp: "12°C", condition: "Foggy / Mist", humidity: "75%", wind: "18 km/h", icon: "🌫️" },
                "Alpine Desert": { temp: "3°C", condition: "High UV / Clear", humidity: "20%", wind: "24 km/h", icon: "☀️" },
                "Arctic": { temp: "-17°C", condition: "Snow / Strong Winds", humidity: "10%", wind: "52 km/h", icon: "❄️" }
            }[zone] || { temp: "20°C", condition: "Partly Cloudy", humidity: "60%", wind: "10 km/h", icon: "⛅" });
            setLoading(false);
        }, 800);
        return () => clearTimeout(timer);
    }, [zone]);

    if (loading) return (
        <div style={{ backgroundColor: 'var(--lux-dark)', height: compact ? '140px' : '180px', display: 'flex', alignItems: 'center', justifyContent: 'center' }}>
            <div style={{ width: '20px', height: '20px', border: '2px solid rgba(255,255,255,0.1)', borderTopColor: '#fff', borderRadius: '50%', animation: 'lux-spin 0.8s linear infinite' }}></div>
            <style>{`@keyframes lux-spin { to { transform: rotate(360deg); } }`}</style>
        </div>
    );

    return (
        <motion.div
            initial={{ opacity: 0, y: 10 }}
            animate={{ opacity: 1, y: 0 }}
            style={{
                backgroundColor: 'var(--lux-dark)',
                color: '#fff',
                padding: compact ? '20px' : '30px',
                border: compact ? 'none' : '1px solid rgba(255,255,255,0.1)',
                position: 'relative',
                overflow: 'hidden',
                height: '100%'
            }}
        >
            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: '20px' }}>
                <div>
                    <span style={{ textTransform: 'uppercase', fontSize: '0.6rem', letterSpacing: '2px', color: 'var(--lux-tan)', display: 'block' }}>Mt. Kilimanjaro</span>
                    <span style={{ fontSize: '1rem', fontFamily: 'Playfair Display' }}>Live Conditions</span>
                </div>
                <div style={{ textAlign: 'right' }}>
                    <span style={{ fontSize: '0.6rem', opacity: 0.5, display: 'block' }}>Update: Live</span>
                    <span style={{ fontSize: '0.7rem', color: 'var(--lux-tan)' }}>Station KALI-1</span>
                </div>
            </div>

            <div style={{ display: 'flex', alignItems: 'center', gap: '25px' }}>
                <span style={{ fontSize: '3.5rem' }}>{weather.icon}</span>
                <div>
                    <div style={{ fontSize: '3rem', fontFamily: 'Playfair Display', lineHeight: 1 }}>{weather.temp}</div>
                    <div style={{ fontSize: '0.9rem', color: 'rgba(255,255,255,0.7)', marginTop: '5px' }}>{weather.condition}</div>
                </div>
            </div>

            <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '20px', marginTop: '30px', borderTop: '1px solid rgba(255,255,255,0.1)', paddingTop: '20px' }}>
                <div>
                    <span style={{ display: 'block', fontSize: '0.6rem', textTransform: 'uppercase', color: 'rgba(255,255,255,0.5)', letterSpacing: '1px' }}>Wind Velocity</span>
                    <span style={{ fontSize: '1.1rem', fontFamily: 'Playfair Display' }}>{weather.wind}</span>
                </div>
                <div>
                    <span style={{ display: 'block', fontSize: '0.6rem', textTransform: 'uppercase', color: 'rgba(255,255,255,0.5)', letterSpacing: '1px' }}>Current Zone</span>
                    <span style={{ fontSize: '1.1rem', fontFamily: 'Playfair Display', color: 'var(--lux-tan)' }}>{zone}</span>
                </div>
            </div>
        </motion.div>
    );
};

/**
 * SafariCalendar - A bespoke interactive departure selector
 */
export const SafariCalendar = ({ itinerary = [], compact = false }) => {
    const [selectedDate, setSelectedDate] = useState(null);
    const [viewMonth, setViewMonth] = useState(new Date().getMonth());
    const [viewYear, setViewYear] = useState(new Date().getFullYear());

    const daysInMonth = (month, year) => new Date(year, month + 1, 0).getDate();
    const firstDayOfMonth = (month, year) => new Date(year, month, 1).getDay();

    const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

    const handleDateClick = (day) => {
        const date = new Date(viewYear, viewMonth, day);
        setSelectedDate(date);
    };

    const getForecast = () => {
        if (!selectedDate) return null;

        return itinerary.map((day, idx) => {
            const current = new Date(selectedDate);
            current.setDate(selectedDate.getDate() + idx);

            // Plausible mountain weather logic
            const m = current.getMonth();
            const isRainy = [3, 4, 10, 11].includes(m);
            const isCold = [5, 6, 7].includes(m);

            let condition = "Clear";
            let icon = "☀️";
            if (isRainy) { condition = "Rainy"; icon = "🌧️"; }
            else if (isCold) { condition = "Mist"; icon = "🌫️"; }
            else if (Math.random() > 0.8) { condition = "Snow"; icon = "❄️"; }

            return {
                dayNum: day.day,
                date: current.toLocaleDateString('en-US', { weekday: 'short', day: 'numeric' }),
                icon: icon,
                temp: day.day > 5 ? "-15°C" : "8°C"
            };
        });
    };

    const forecast = getForecast();

    return (
        <div style={{ backgroundColor: '#fff', border: compact ? 'none' : '1px solid var(--lux-border)', padding: compact ? '0' : '40px' }}>
            {compact ? (
                <div style={{ border: '1px solid var(--lux-border)', padding: '30px' }}>
                    <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: '20px' }}>
                        <span style={{ fontFamily: 'var(--font-heading)', fontSize: '1.2rem' }}>Secure <em>Departure</em></span>
                        <div style={{ display: 'flex', gap: '15px' }}>
                            <button onClick={() => setViewMonth(m => (m === 0 ? 11 : m - 1))} style={{ background: 'none', border: 'none', cursor: 'pointer' }}>←</button>
                            <span style={{ fontSize: '0.8rem', fontWeight: '600' }}>{months[viewMonth].slice(0, 3)} {viewYear}</span>
                            <button onClick={() => setViewMonth(m => (m === 11 ? 0 : m + 1))} style={{ background: 'none', border: 'none', cursor: 'pointer' }}>→</button>
                        </div>
                    </div>

                    <div style={{ display: 'grid', gridTemplateColumns: 'repeat(7, 1fr)', gap: '2px', textAlign: 'center', marginBottom: '30px' }}>
                        {['S', 'M', 'T', 'W', 'T', 'F', 'S'].map(d => (
                            <div key={d} style={{ fontSize: '0.6rem', color: '#aaa', padding: '5px 0' }}>{d}</div>
                        ))}
                        {[...Array(firstDayOfMonth(viewMonth, viewYear))].map((_, i) => <div key={`empty-${i}`} />)}
                        {[...Array(daysInMonth(viewMonth, viewYear))].map((_, i) => {
                            const d = i + 1;
                            const isSelected = selectedDate && selectedDate.getDate() === d && selectedDate.getMonth() === viewMonth;
                            return (
                                <button key={d} onClick={() => handleDateClick(d)} style={{ padding: '8px 0', border: 'none', backgroundColor: isSelected ? 'var(--lux-tan)' : 'transparent', color: isSelected ? '#fff' : '#444', fontSize: '0.75rem', cursor: 'pointer' }}>{d}</button>
                            );
                        })}
                    </div>

                    <AnimatePresence mode="wait">
                        {forecast && (
                            <motion.div initial={{ opacity: 0 }} animate={{ opacity: 1 }} style={{ backgroundColor: 'var(--lux-cream)', padding: '15px', fontSize: '0.8rem' }}>
                                <div style={{ display: 'grid', gap: '8px' }}>
                                    {forecast.slice(0, 4).map((f, i) => (
                                        <div key={i} style={{ display: 'flex', justifyContent: 'space-between' }}>
                                            <span style={{ opacity: 0.6 }}>Day {f.dayNum}</span>
                                            <span>{f.icon} {f.temp}</span>
                                        </div>
                                    ))}
                                </div>
                            </motion.div>
                        )}
                    </AnimatePresence>
                </div>
            ) : (
                <>
                    <div style={{ textAlign: 'center', marginBottom: '40px' }}>
                        <h3 style={{ fontFamily: 'Playfair Display', fontSize: '2rem' }}>Secure Your <em>Departure.</em></h3>
                        <p style={{ color: '#666', fontSize: '0.9rem' }}>Select a date to preview itinerary weather dynamics.</p>
                    </div>

                    <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '40px', alignItems: 'start' }}>
                        {/* Visual Calendar Grid (Original) */}
                        <div>
                            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: '20px' }}>
                                <button onClick={() => setViewMonth(m => (m === 0 ? 11 : m - 1))} style={{ background: 'none', border: 'none', cursor: 'pointer', color: 'var(--lux-tan)' }}>←</button>
                                <span style={{ fontFamily: 'Playfair Display', fontWeight: 'bold' }}>{months[viewMonth]} {viewYear}</span>
                                <button onClick={() => setViewMonth(m => (m === 11 ? 0 : m + 1))} style={{ background: 'none', border: 'none', cursor: 'pointer', color: 'var(--lux-tan)' }}>→</button>
                            </div>

                            <div style={{ display: 'grid', gridTemplateColumns: 'repeat(7, 1fr)', gap: '5px', textAlign: 'center' }}>
                                {['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'].map(d => (
                                    <div key={d} style={{ fontSize: '0.65rem', color: '#aaa', fontWeight: 'bold', padding: '10px 0', textTransform: 'uppercase', letterSpacing: '1px' }}>{d.charAt(0)}</div>
                                ))}
                                {[...Array(firstDayOfMonth(viewMonth, viewYear))].map((_, i) => <div key={`empty-${i}`} />)}
                                {[...Array(daysInMonth(viewMonth, viewYear))].map((_, i) => {
                                    const d = i + 1;
                                    const isSelected = selectedDate && selectedDate.getDate() === d && selectedDate.getMonth() === viewMonth;
                                    return (
                                        <button
                                            key={d}
                                            onClick={() => handleDateClick(d)}
                                            style={{
                                                padding: '10px 0',
                                                border: 'none',
                                                backgroundColor: isSelected ? 'var(--lux-dark)' : 'transparent',
                                                color: isSelected ? '#fff' : 'var(--lux-dark)',
                                                fontFamily: 'Inter',
                                                fontSize: '0.85rem',
                                                cursor: 'pointer',
                                                transition: 'all 0.2s ease'
                                            }}
                                        >
                                            {d}
                                        </button>
                                    );
                                })}
                            </div>
                        </div>

                        {/* Forecast Display (Original) */}
                        <div>
                            <AnimatePresence mode="wait">
                                {forecast ? (
                                    <motion.div
                                        initial={{ opacity: 0, x: 20 }}
                                        animate={{ opacity: 1, x: 0 }}
                                        exit={{ opacity: 0, x: -20 }}
                                        style={{ backgroundColor: 'var(--lux-cream)', padding: '25px', border: '1px solid var(--lux-border)' }}
                                    >
                                        <h4 style={{ fontFamily: 'Playfair Display', borderBottom: '1px solid var(--lux-border)', paddingBottom: '10px', marginBottom: '20px' }}>Daily <em>Forecast.</em></h4>
                                        <div style={{ display: 'grid', gap: '15px' }}>
                                            {forecast.slice(0, 6).map((f, i) => (
                                                <div key={i} style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', fontSize: '0.85rem' }}>
                                                    <span style={{ opacity: 0.6 }}>{f.date}</span>
                                                    <span style={{ fontWeight: 'bold' }}>{f.icon} {f.condition}</span>
                                                    <span style={{ color: 'var(--lux-tan)' }}>{f.temp}</span>
                                                </div>
                                            ))}
                                        </div>
                                    </motion.div>
                                ) : (
                                    <div style={{ height: '300px', display: 'flex', alignItems: 'center', justifyContent: 'center', border: '1px dashed var(--lux-border)', textAlign: 'center', padding: '20px' }}>
                                        <p style={{ color: '#888', fontSize: '0.9rem' }}>Select a date on the calendar to project your mountain conditions.</p>
                                    </div>
                                )}
                            </AnimatePresence>
                        </div>
                    </div>
                </>
            )}
        </div>
    );
};
