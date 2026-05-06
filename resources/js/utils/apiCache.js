/**
 * Simple in-memory API response cache with TTL.
 * Prevents re-fetching the same data on every page navigation.
 */
const cache = new Map();

const DEFAULT_TTL = 5 * 60 * 1000; // 5 minutes

export function getCached(key) {
    const entry = cache.get(key);
    if (!entry) return null;
    if (Date.now() > entry.expiresAt) {
        cache.delete(key);
        return null;
    }
    return entry.data;
}

export function setCache(key, data, ttl = DEFAULT_TTL) {
    cache.set(key, {
        data,
        expiresAt: Date.now() + ttl,
    });
}

export function clearCache(pattern) {
    if (!pattern) {
        cache.clear();
        return;
    }
    for (const key of cache.keys()) {
        if (key.includes(pattern)) {
            cache.delete(key);
        }
    }
}

/**
 * Wraps an async API call with caching.
 * If cached data exists and is fresh, returns it immediately.
 * Otherwise calls the fetch function, caches the result, and returns it.
 */
export async function withCache(key, fetchFn, ttl = DEFAULT_TTL) {
    const cached = getCached(key);
    if (cached !== null) return cached;

    const data = await fetchFn();
    setCache(key, data, ttl);
    return data;
}
