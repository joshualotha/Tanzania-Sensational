import React from 'react';
import { SettingsProvider } from '../../context/SettingsContext';
import { useSettings } from '../../context/SettingsContext';
import { VisualsProvider } from '../../context/VisualsContext';
import { TopBar } from './TopBar';
import { Navbar } from './Navbar';
import { Breadcrumbs } from './Breadcrumbs';
import { Footer } from './Footer';

const WhatsAppFloat = () => {
    const { settings } = useSettings();
    const rawPhone = settings?.contact?.whatsapp || settings?.contact?.phone || '+255 743 262 822';
    // Strip all non-digit characters for the wa.me link
    const digits = rawPhone.replace(/\D/g, '');
    const waLink = `https://wa.me/${digits}`;

    return (
        <a
            href={waLink}
            target="_blank"
            rel="noopener noreferrer"
            className="whatsapp-float"
            aria-label="Chat on WhatsApp"
        >
            {/* Official WhatsApp logo SVG */}
            <svg width="28" height="28" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path d="M19.077 4.928C17.191 3.041 14.683 2 12.006 2 6.798 2 2.548 6.25 2.548 11.458c0 1.999.521 3.958 1.511 5.682L2 22l5.042-1.323c1.656.904 3.52 1.38 5.422 1.38h.005c5.207 0 9.457-4.25 9.457-9.458 0-2.676-1.041-5.184-2.928-7.071zM12.006 20.276c-1.694 0-3.357-.455-4.8-1.313l-.344-.204-2.992.785.8-2.918-.224-.357a8.06 8.06 0 01-1.29-4.311c0-4.463 3.631-8.094 8.094-8.094 2.161 0 4.193.842 5.722 2.371a8.06 8.06 0 012.371 5.722c0 4.463-3.631 8.094-8.094 8.094zm4.44-6.062c-.243-.122-1.438-.71-1.66-.791-.223-.081-.385-.122-.547.122-.162.243-.629.791-.771.953-.142.162-.284.182-.527.061-.243-.122-1.026-.378-1.954-1.207-.722-.645-1.21-1.441-1.352-1.685-.142-.243-.015-.375.107-.497.108-.108.243-.284.365-.426.122-.142.162-.243.223-.405.061-.162.03-.304-.015-.426-.046-.122-.548-1.319-.751-1.806-.203-.487-.406-.487-.548-.487-.142 0-.304-.01-.466-.01-.162 0-.426.061-.649.304-.223.243-.852.832-.852 2.028 0 1.196.873 2.352.993 2.514.122.162 1.718 2.62 4.157 3.437.581.25 1.034.4 1.388.512.582.186 1.114.16 1.533.097.47-.07 1.44-.589 1.643-1.157.203-.569.203-1.056.142-1.157-.061-.101-.223-.162-.466-.284z"/>
            </svg>
        </a>
    );
};

const PublicLayout = (page) => {
    return (
        <SettingsProvider>
        <VisualsProvider>
            <div className="app-container">
                <TopBar />
                <Navbar />
                <Breadcrumbs />
                {page}
                <Footer />
                <WhatsAppFloat />
            </div>
        </VisualsProvider>
        </SettingsProvider>
    );
};

export default PublicLayout;
