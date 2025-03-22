import eslintConfigCodely from "eslint-config-codely";

export default [
  ...eslintConfigCodely.full,
  {
    files: ["**/*.{js,jsx,ts,tsx}"],
    rules: {
      // Disable problematic rules
      "import/no-unresolved": "off",
      "prettier/prettier": ["error", { printWidth: 100, useTabs: false, tabWidth: 2 }],
    },
  },
];
