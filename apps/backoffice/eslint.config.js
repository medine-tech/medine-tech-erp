import eslintConfigCodely from "eslint-config-codely";
import reactPlugin from "eslint-plugin-react";
import reactHooks from "eslint-plugin-react-hooks";
import reactRefresh from "eslint-plugin-react-refresh";
import globals from "globals";

// Vite React template ESLint rules
const viteReactRules = {
  // React specific rules
  "react/jsx-uses-react": "off", // Not needed with React 19
  "react/react-in-jsx-scope": "off", // Not needed with React 19
  "react/prop-types": "off", // Not needed when using TypeScript
  "react/jsx-no-target-blank": "warn",

  // React Hooks rules
  "react-hooks/rules-of-hooks": "error",
  "react-hooks/exhaustive-deps": "warn",

  // React Refresh rules
  "react-refresh/only-export-components": ["warn", { allowConstantExport: true }],

  // Import/Export rules
  "import/first": "error",
  // Disable conflicting or problematic rules
  "import/no-duplicates": "off", // Desactivado para evitar conflictos con TypeScript
  "import/order": "off",
};

export default [
  ...eslintConfigCodely.full,
  {
    files: ["**/*.{js,jsx,ts,tsx}"],
    plugins: {
      react: reactPlugin,
      "react-hooks": reactHooks,
      "react-refresh": reactRefresh,
    },
    languageOptions: {
      globals: {
        ...globals.browser,
        React: "readonly",
      },
      parserOptions: {
        ecmaVersion: "latest",
        sourceType: "module",
        ecmaFeatures: {
          jsx: true,
        },
      },
    },
    settings: {
      react: {
        version: "detect",
      },
      // Configuración para resolver imports correctamente
      "import/resolver": {
        node: {
          extensions: [".js", ".jsx", ".ts", ".tsx"],
        },
        typescript: {}, // Añadimos el resolver de typescript
      },
    },
    rules: {
      ...viteReactRules,
      // Disable problematic rules
      "import/no-unresolved": "off",
      "check-file/folder-naming-convention": "off",
      "react-hooks/exhaustive-deps": "off",
      "react-refresh/only-export-components": "off",
      "prettier/prettier": ["error", { printWidth: 100, useTabs: false, tabWidth: 2 }],
    },
  },
  // Special config for vite.config.ts and other config files
  {
    files: ["*.config.{js,ts,mjs,cjs}", "vite.config.*"],
    languageOptions: {
      globals: globals.node,
    },
  },
];
