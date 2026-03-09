import React from 'react';
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';
import { TopBar } from './components/layout/TopBar';
import { Navbar } from './components/layout/Navbar';
import { Footer } from './components/layout/Footer';
import { HomePage } from './pages/HomePage';
import { ContactPage } from './pages/ContactPage';
import { AboutPage } from './pages/AboutPage';
import { SafarisPage } from './pages/SafarisPage';
import { ZanzibarPage } from './pages/ZanzibarPage';
import { SafariPackagesList } from './pages/safaris/SafariPackagesList';
import { SafariPackageDetail } from './pages/safaris/SafariPackageDetail';
import { DestinationDetail } from './pages/safaris/DestinationDetail';
import { BlogList } from './pages/blog/BlogList';
import { BlogDetail } from './pages/blog/BlogDetail';

// New 'Plan Your Trip' Pages
import { MtMeru } from './pages/plan/MtMeru';
import { GroupDepartures } from './pages/plan/GroupDepartures';
import { GearChecklist } from './pages/plan/GearChecklist';
import { TrainingGuide } from './pages/plan/TrainingGuide';
import { FAQ } from './pages/plan/FAQ';
import { SafariAddons } from './pages/plan/SafariAddons';

import Vaccinations from './pages/trekking/health/Vaccinations';
import AltitudeSickness from './pages/trekking/health/AltitudeSickness';
import Diamox from './pages/trekking/health/Diamox';
import Oxygen from './pages/trekking/health/Oxygen';

// Trekking Prep Pages
import BestRoutes from './pages/trekking/prep/BestRoutes';
import BestTime from './pages/trekking/prep/BestTime';
import WhyUs from './pages/trekking/prep/WhyUs';
import TippingGuide from './pages/trekking/prep/TippingGuide';
import Toilets from './pages/trekking/prep/Toilets';
import ParkFees from './pages/trekking/prep/ParkFees';

import Training from './pages/trekking/after/Training';
import GearList from './pages/trekking/after/GearList';
import GettingThere from './pages/trekking/after/GettingThere';
import Visa from './pages/trekking/after/Visa';

// During the Trek Pages
import DailyRoutine from './pages/trekking/during/DailyRoutine';
import FoodAndDrinks from './pages/trekking/during/FoodAndDrinks';
import PackYourDaypack from './pages/trekking/during/PackYourDaypack';
import Connectivity from './pages/trekking/during/Connectivity';

// Kilimanjaro Route Pages
import Lemosho from './pages/trekking/kilimanjaro/Lemosho';
import Machame from './pages/trekking/kilimanjaro/Machame';
import Rongai from './pages/trekking/kilimanjaro/Rongai';
import Marangu from './pages/trekking/kilimanjaro/Marangu';
import NorthernCircuit from './pages/trekking/kilimanjaro/NorthernCircuit';
import Umbwe from './pages/trekking/kilimanjaro/Umbwe';
import PackageDetail from './pages/trekking/kilimanjaro/PackageDetail';

function App() {
    return (
        <Router>
            <div className="app-container">
                <TopBar />
                <Navbar />
                <Routes>
                    <Route path="/" element={<HomePage />} />
                    <Route path="/about" element={<AboutPage />} />
                    <Route path="/contact" element={<ContactPage />} />
                    <Route path="/safaris" element={<SafarisPage />} />
                    <Route path="/safaris/destinations/:id" element={<DestinationDetail />} />
                    <Route path="/safaris/packages" element={<SafariPackagesList />} />
                    <Route path="/safaris/packages/:packageId" element={<SafariPackageDetail />} />
                    <Route path="/zanzibar" element={<ZanzibarPage />} />
                    <Route path="/blog" element={<BlogList />} />
                    <Route path="/blog/:slug" element={<BlogDetail />} />

                    {/* New 'Plan Your Trip' Routes */}
                    <Route path="/meru" element={<MtMeru />} />
                    <Route path="/group-departures" element={<GroupDepartures />} />
                    <Route path="/gear-checklist" element={<GearChecklist />} />
                    <Route path="/training-guide" element={<TrainingGuide />} />
                    <Route path="/faq" element={<FAQ />} />
                    <Route path="/safari-addons" element={<SafariAddons />} />

                    {/* Trekking Health & Safety */}
                    <Route path="/trekking/health/vaccinations" element={<Vaccinations />} />
                    <Route path="/trekking/health/altitude-sickness" element={<AltitudeSickness />} />
                    <Route path="/trekking/health/diamox" element={<Diamox />} />
                    <Route path="/trekking/health/oxygen" element={<Oxygen />} />

                    {/* Trekking Prep Routes */}
                    <Route path="/trekking/prep/best-routes" element={<BestRoutes />} />
                    <Route path="/trekking/prep/best-time" element={<BestTime />} />
                    <Route path="/trekking/prep/why-us" element={<WhyUs />} />
                    <Route path="/trekking/prep/tipping-guide" element={<TippingGuide />} />
                    <Route path="/trekking/prep/toilets" element={<Toilets />} />
                    <Route path="/trekking/prep/park-fees" element={<ParkFees />} />

                    <Route path="/trekking/after/training" element={<Training />} />
                    <Route path="/trekking/after/gear-list" element={<GearList />} />
                    <Route path="/trekking/after/getting-there" element={<GettingThere />} />
                    <Route path="/trekking/after/visa" element={<Visa />} />

                    <Route path="/trekking/during/daily-routine" element={<DailyRoutine />} />
                    <Route path="/trekking/during/food-and-drinks" element={<FoodAndDrinks />} />
                    <Route path="/trekking/during/pack-your-daypack" element={<PackYourDaypack />} />
                    <Route path="/trekking/during/connectivity" element={<Connectivity />} />

                    {/* Kilimanjaro Route Pages */}
                    <Route path="/trekking/kilimanjaro/lemosho" element={<Lemosho />} />
                    <Route path="/trekking/kilimanjaro/machame" element={<Machame />} />
                    <Route path="/trekking/kilimanjaro/rongai" element={<Rongai />} />
                    <Route path="/trekking/kilimanjaro/marangu" element={<Marangu />} />
                    <Route path="/trekking/kilimanjaro/northern-circuit" element={<NorthernCircuit />} />
                    <Route path="/trekking/kilimanjaro/umbwe" element={<Umbwe />} />

                    {/* Dynamic Dedicated Package Detail Route */}
                    <Route path="/trekking/kilimanjaro/:routeId/:packageId" element={<PackageDetail />} />
                </Routes>
                <Footer />

                {/* WhatsApp Float */}
                <a href="https://wa.me/255700000000" className="whatsapp-float" target="_blank" aria-label="WhatsApp">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="white">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                    </svg>
                </a>
            </div>
        </Router>
    );
}

export default App;
