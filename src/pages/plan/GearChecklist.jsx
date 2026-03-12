import { Link } from 'react-router-dom';
import { visualsData } from '../../data/visualsData';
import '../../styles/utility-pages-premium.css';

export const GearChecklist = () => {
    useEffect(() => {
        window.scrollTo(0, 0);
    }, []);

    const fadeInUp = {
        hidden: { opacity: 0, y: 30 },
        visible: { opacity: 1, y: 0, transition: { duration: 0.8 } }
    };

    return (
        <div className="utility-root">
            <section className="utility-hero">
                <div className="utility-hero-bg">
                    <img src={visualsData.planning.gearHero} alt="Mountain Gear" />
                </div>
                <div className="utility-hero-overlay"></div>
                <motion.div className="utility-hero-content" initial="hidden" animate="visible" variants={fadeInUp}>
                    <span className="utility-hero-eyebrow">Preparation</span>
                    <h1 className="utility-hero-title">Gear Checklist</h1>
                    <p className="utility-hero-subtitle">
                        From the tropical rainforest to the arctic summit, climbing Kilimanjaro requires a highly adaptable layering system. Make sure you don't compromise on the essentials.
                    </p>
                </motion.div>
            </section>

            <section className="utility-content">
                <div className="utility-grid">
                    <motion.div className="util-card" initial="hidden" whileInView="visible" viewport={{ once: true }} variants={fadeInUp}>
                        <h3 className="util-card-title">Technical Clothing</h3>
                        <ul className="util-card-list">
                            <li>1x Waterproof Jacket, breathable (Gore-Tex)</li>
                            <li>1x Insulated Down Jacket (600+ fill)</li>
                            <li>1x Fleece Jacket or warm mid-layer</li>
                            <li>2x Moisture-wicking base layers (top & bottom)</li>
                            <li>2x Trekking pants (1 convertible advised)</li>
                            <li>1x Waterproof trousers</li>
                            <li>4x Synthetic or merino wool t-shirts</li>
                        </ul>
                    </motion.div>

                    <motion.div className="util-card" initial="hidden" whileInView="visible" viewport={{ once: true }} variants={fadeInUp}>
                        <h3 className="util-card-title">Head, Hands & Feet</h3>
                        <ul className="util-card-list">
                            <li>Warm beanie or balaclava</li>
                            <li>Wide-brimmed sun hat</li>
                            <li>Heavyweight insulated waterproof mittens</li>
                            <li>Lightweight fleece gloves (liner)</li>
                            <li>Premium waterproof trekking boots (broken in!)</li>
                            <li>Camp shoes (trainers or sturdy sandals)</li>
                            <li>4-5x Heavyweight merino wool trekking socks</li>
                        </ul>
                    </motion.div>

                    <motion.div className="util-card" initial="hidden" whileInView="visible" viewport={{ once: true }} variants={fadeInUp}>
                        <h3 className="util-card-title">Equipment & Accessories</h3>
                        <ul className="util-card-list">
                            <li>Sleeping bag (-15°C / 5°F rating)</li>
                            <li>Trekking poles (collapsible)</li>
                            <li>Headlamp with spare lithium batteries</li>
                            <li>30L-40L Daypack (with rain cover)</li>
                            <li>70L-90L Duffel bag (for porters to carry)</li>
                            <li>2x 1-Liter Nalgene water bottles (or bladder)</li>
                            <li>High UV protection sunglasses (Category 3-4)</li>
                        </ul>
                    </motion.div>
                </div>

                <div style={{ textAlign: 'center', marginTop: '60px' }}>
                    <p style={{ color: 'rgba(255,255,255,0.6)', marginBottom: '20px' }}>* Premium rental gear (including -20°C sleeping bags and down jackets) is available upon arrival in Moshi.</p>
                </div>
            </section>
        </div>
    );
};
