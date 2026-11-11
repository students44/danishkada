<style>
    /* DanishKada Luxury Styling Enhancements */
    :root {
        --font-family: 'Outfit', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }

    body {
        font-family: var(--font-family);
        -webkit-font-smoothing: antialiased;
    }

    /* Strict Logo Constraints */
    .fi-logo,
    .fi-logo-light,
    .fi-logo-dark {
        max-height: 2.75rem !important;
        overflow: hidden !important;
        display: flex !important;
        align-items: center !important;
    }
    .fi-logo svg,
    .fi-sidebar-header svg {
        max-height: 24px !important;
        max-width: 24px !important;
    }

    /* Polished Card & Widget styling */
    .fi-wi-stats-overview .fi-wi-stats-overview-stat,
    .fi-section {
        border-radius: 1rem !important;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1) !important;
        box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05), 0 2px 6px -1px rgba(0, 0, 0, 0.02) !important;
    }

    .dark .fi-wi-stats-overview .fi-wi-stats-overview-stat,
    .dark .fi-section {
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.4), 0 8px 10px -6px rgba(0, 0, 0, 0.2) !important;
    }

    .fi-wi-stats-overview .fi-wi-stats-overview-stat:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 28px -4px rgba(249, 115, 22, 0.12), 0 8px 10px -4px rgba(0, 0, 0, 0.04) !important;
    }

    /* Modern scrollbar */
    ::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }
    ::-webkit-scrollbar-track {
        background: transparent;
    }
    ::-webkit-scrollbar-thumb {
        background: rgba(156, 163, 175, 0.5);
        border-radius: 9999px;
    }
    ::-webkit-scrollbar-thumb:hover {
        background: rgba(107, 114, 128, 0.8);
    }

    /* Smooth table row transitions */
    .fi-ta-record {
        transition: background-color 0.15s ease-in-out;
    }
    .fi-ta-record:hover {
        background-color: rgba(249, 115, 22, 0.03) !important;
    }
    .dark .fi-ta-record:hover {
        background-color: rgba(255, 255, 255, 0.02) !important;
    }

    /* Live status badge pulsing */
    @keyframes dk-pulse {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.6; transform: scale(1.08); }
    }
    .dk-live-dot {
        animation: dk-pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }

    /* Polished sidebar item hover */
    .fi-sidebar-item-button {
        border-radius: 0.75rem !important;
        font-weight: 500 !important;
        transition: all 0.2s ease !important;
    }
</style>
