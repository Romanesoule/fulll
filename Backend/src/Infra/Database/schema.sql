CREATE TABLE IF NOT EXISTS fleets (
    id TEXT PRIMARY KEY,
    user_id TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS vehicles (
    id INTEGER PRIMARY KEY,
    plate_number TEXT NOT NULL,
    fleet_id TEXT NOT NULL,
    FOREIGN KEY (fleet_id) REFERENCES fleets(id)
);

CREATE TABLE IF NOT EXISTS locations (
     id INTEGER PRIMARY KEY AUTOINCREMENT,
     latitude REAL NOT NULL,
     longitude REAL NOT NULL,
     altitude REAL DEFAULT NULL,
     recorded_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS vehicle_locations (
    vehicle_id TEXT NOT NULL,
    location_id INTEGER NOT NULL,
    PRIMARY KEY (vehicle_id, location_id),
    FOREIGN KEY (vehicle_id) REFERENCES vehicles(id),
    FOREIGN KEY (location_id) REFERENCES locations(id)
);