/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./app/**/*.php",
    ],
    theme: {
        extend: {
            colors: {
                // Custom neon colors
                "neon-pink": "#e91e63",
                "neon-purple": "#9c27b0",
                "neon-green": "#4caf50",
                "neon-blue": "#2196f3",
                "neon-yellow": "#ff9800",
                "neon-orange": "#f44336",
                "neon-cyan": "#00bcd4",
                "neon-teal": "#009688",

                // Dark theme colors
                "bg-primary": "#1a1a2e",
                "bg-secondary": "#252542",
                "bg-tertiary": "#2f2f4e",
                "bg-card": "#252542",
                "bg-hover": "#2f2f4e",
                "bg-surface": "#353552",

                // Text colors
                "text-primary": "#f5f5f5",
                "text-secondary": "#b0bec5",
                "text-muted": "#64748b",
                "text-accent": "#4caf50",

                // Standard colors
                primary: "#0d6efd",
                success: "#198754",
                danger: "#dc3545",
                warning: "#ffc107",
                info: "#0dcaf0",
                "light-bg": "#f8f9fa",
            },
            backgroundImage: {
                "primary-gradient":
                    "linear-gradient(135deg, #e91e63 0%, #9c27b0 100%)",
                "secondary-gradient":
                    "linear-gradient(135deg, #4caf50 0%, #2196f3 100%)",
                "accent-gradient":
                    "linear-gradient(135deg, #ff9800 0%, #f44336 100%)",
                "success-gradient":
                    "linear-gradient(135deg, #66bb6a 0%, #43a047 100%)",
                "quote-gradient":
                    "linear-gradient(135deg, #667eea 0%, #764ba2 100%)",
            },
            spacing: {
                xs: "0.25rem",
                sm: "0.5rem",
                md: "1rem",
                lg: "1.5rem",
                xl: "2rem",
                "2xl": "3rem",
            },
            borderRadius: {
                sm: "8px",
                md: "12px",
                lg: "16px",
                xl: "24px",
            },
            fontFamily: {
                primary: [
                    '"Inter"',
                    '"SF Pro Display"',
                    "-apple-system",
                    "BlinkMacSystemFont",
                    '"Segoe UI"',
                    "sans-serif",
                ],
                display: ['"Clash Display"', '"Inter"', "sans-serif"],
                mono: ['"JetBrains Mono"', '"Fira Code"', "monospace"],
            },
            boxShadow: {
                neon: "0 0 20px rgba(76, 175, 80, 0.2)",
                soft: "0 4px 16px rgba(0, 0, 0, 0.1)",
            },
            transitionDuration: {
                fast: "0.2s",
                normal: "0.3s",
                slow: "0.5s",
            },
            transitionTimingFunction: {
                custom: "cubic-bezier(0.4, 0, 0.2, 1)",
            },
            animation: {
                "pulse-slow": "pulse 2s infinite",
                glow: "glow 2s ease-in-out infinite alternate",
                float: "float 6s ease-in-out infinite",
                shimmer: "shimmer 2s infinite",
                loading: "loading 1.5s infinite",
                "fade-in": "fadeIn 0.3s ease",
            },
            keyframes: {
                pulse: {
                    "0%, 100%": { opacity: "1" },
                    "50%": { opacity: "0.7" },
                },
                glow: {
                    from: { boxShadow: "0 0 5px #00bcd4" },
                    to: { boxShadow: "0 0 20px #00bcd4, 0 0 30px #00bcd4" },
                },
                float: {
                    "0%, 100%": { transform: "translateY(0px) rotate(0deg)" },
                    "50%": { transform: "translateY(-20px) rotate(180deg)" },
                },
                shimmer: {
                    "0%": { transform: "translateX(-100%)" },
                    "100%": { transform: "translateX(100%)" },
                },
                loading: {
                    "0%": { transform: "translateX(-100%)" },
                    "100%": { transform: "translateX(100%)" },
                },
                fadeIn: {
                    from: { opacity: "0", transform: "translateY(10px)" },
                    to: { opacity: "1", transform: "translateY(0)" },
                },
            },
        },
    },
    plugins: [],
};
