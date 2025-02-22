// eslint.config.js
import { FlatCompat } from "@eslint/eslintrc";
import eslintConfigCodely from "eslint-config-codely";
import { dirname } from "path";
import { fileURLToPath } from "url";

const __filename = fileURLToPath(import.meta.url);
const __dirname = dirname(__filename);

const compat = new FlatCompat({
	baseDirectory: __dirname,
});

const eslintConfig = [
	...compat.config({
		extends: ["next/typescript"],
	}),
	...eslintConfigCodely.full,
];

export default eslintConfig;
