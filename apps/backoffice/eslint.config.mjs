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
  ...compat.config({
    rules: {
      "prettier/prettier": ["error", { printWidth: 100, useTabs: false, tabWidth: 2 }],
    },
  }),
];

export default eslintConfig;
