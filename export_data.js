import fs from 'fs';
import { departuresData } from './resources/js/data/departuresData.js';
import { packagesData } from './resources/js/data/packagesData.js';
import { destinationsData } from './resources/js/data/destinationsData.js';
import { safarisData } from './resources/js/data/safarisData.js';
import { blogsData } from './resources/js/data/blogsData.js';

fs.mkdirSync('./storage/app/data_export', { recursive: true });
fs.writeFileSync('./storage/app/data_export/departures.json', JSON.stringify(departuresData, null, 2));
fs.writeFileSync('./storage/app/data_export/packages.json', JSON.stringify(packagesData, null, 2));
fs.writeFileSync('./storage/app/data_export/destinations.json', JSON.stringify(destinationsData, null, 2));
fs.writeFileSync('./storage/app/data_export/safaris.json', JSON.stringify(safarisData, null, 2));
fs.writeFileSync('./storage/app/data_export/blogs.json', JSON.stringify(blogsData, null, 2));
console.log("Data exported to JSON successfully.");
