import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                gold: {
                    700: 'var(--gold-700)',
                    500: 'var(--gold-500)',
                    300: 'var(--gold-300)',
                    50: 'var(--gold-50)',
                },
                ink: 'var(--ink)',
                slate: 'var(--slate)',
                muted: 'var(--muted)',
                line: 'var(--line)',
                'line-chip': 'var(--line-chip)',
                handle: 'var(--handle)',
                canvas: 'var(--canvas)',
                track: 'var(--track)',
                'on-ink-soft': 'var(--on-ink-soft)',
                'on-ink-muted': 'var(--on-ink-muted)',
                success: 'var(--success)',
                warning: 'var(--warning)',
                danger: 'var(--danger)',
                'tint-gold': 'var(--tint-gold)',
                'tint-success': 'var(--tint-success)',
                'tint-warning': 'var(--tint-warning)',
                'tint-ink': 'var(--tint-ink)',
                'tint-danger': 'var(--tint-danger)',
                'danger-soft': 'var(--fill-danger-soft)',
                'danger-border': 'var(--border-danger)',
                'gold-border': 'var(--border-gold-chip)',
                segmented: 'var(--track-segmented)',
            },
            boxShadow: {
                fab: 'var(--shadow-fab)',
                segment: 'var(--shadow-segment-active)',
            },
        },
    },

    plugins: [forms],
};