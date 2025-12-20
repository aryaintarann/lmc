/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        brand: {
          primary: '#2E4D36',
          secondary: '#1A2E22',
          accent: '#C5A059',
          white: '#FFFFFF',
        }
      }
    },
  },
  plugins: [],
}
