import js from "@eslint/js";
import eslintConfigCodely from "eslint-config-codely";
import reactPlugin from "eslint-plugin-react";
import reactHooks from "eslint-plugin-react-hooks";
import reactRefresh from "eslint-plugin-react-refresh";
import globals from "globals";

export default [
	// Ignore node_modules, build directories, and TypeScript files to avoid parsing errors
	// {
	// 	ignores: ['dist', 'node_modules', '.turbo', '.next', '**/*.ts', '**/*.tsx', 'src/**/*'],
	// },

	// Base JS settings
	js.configs.recommended,

	// Configuration for JavaScript/TypeScript files
	{
		files: ["**/*.{js,jsx}"],
		languageOptions: {
			ecmaVersion: 2020,
			sourceType: "module",
			globals: {
				...globals.browser,
				...globals.node,
			},
		},
	},

	// React configuration with hooks
	{
		files: ["**/*.{jsx,tsx}"],
		plugins: {
			react: reactPlugin,
			"react-hooks": reactHooks,
			"react-refresh": reactRefresh,
		},
		languageOptions: {
			globals: {
				React: "readonly",
			},
		},
		settings: {
			react: {
				version: "detect",
			},
		},
		rules: {
			// React
			"react/jsx-uses-react": "off", // Not needed with React 19
			"react/react-in-jsx-scope": "off", // Not needed with React 19
			"react/jsx-boolean-value": ["error", "never"],
			"react/jsx-closing-bracket-location": "error",
			"react/jsx-curly-spacing": ["error", { when: "never" }],
			"react/jsx-equals-spacing": ["error", "never"],
			"react/jsx-indent": ["error", 2],
			"react/jsx-indent-props": ["error", 2],
			"react/jsx-no-duplicate-props": "error",

			// React hooks
			"react-hooks/rules-of-hooks": "error",
			"react-hooks/exhaustive-deps": "warn",

			// React refresh
			"react-refresh/only-export-components": ["warn", { allowConstantExport: true }],
		},
	},

	// TypeScript files
	{
		files: ["**/*.{ts,tsx}"],
		languageOptions: {
			globals: {
				...globals.browser,
			},
		},
	},

	// Special config for vite.config.ts to allow Node globals
	{
		files: ["vite.config.ts"],
		languageOptions: {
			globals: {
				...globals.node,
			},
		},
	},
	...eslintConfigCodely.ts,
];
