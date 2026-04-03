import js from "@eslint/js";
import globals from "globals";

import json from "@eslint/json";
import markdown from "@eslint/markdown";
import css from "@eslint/css";

//import { defineConfig } from "eslint/config";

const cssFiles =
{
	files: ["**/*.css"],
	...css.configs.recommended,
	plugins: { css },
	language: "css/css"
};

const jsonFiles =
{
	files: ["**/*.json"],
	...json.configs.recommended,
	plugins: { json },
	language: "json/json"
};

const jsoncFiles =
{
	files: ["**/*.jsonc"],
	...json.configs.recommended,
	plugins: { json },
	language: "json/jsonc"
};

const json5Files =
{
	files: ["**/*.json5"],
	...json.configs.recommended,
	plugins: { json },
	language: "json/json5"
};

const jstFiles =
{
 	files: ["**/*.{js,mjs,cjs}"],
	plugins: { js },
	languageOptions:
	{
		sourceType: "module",
		globals:
		{
			...globals.browser,
			...globals.node
		}
	},
	rules:
	{
		"no-console": "off",
		"no-unused-vars": "warn",
	},
};

const mdFiles =
{
	files: ["**/*.md"],
	...markdown.configs.recommended,
	plugins: { markdown },
	language: "markdown/gfm"
};

const ignores =
{
	ignores:
	[
		"node_modules/**",
		"../**/node_modules/**",
		"../../DevelopmentTools/**",
		"vendor/**",
		"dist/**",
		"build/**",
	],
};

const defineConfig =
[
	js.configs.recommended,
	cssFiles,
	jsonFiles,
	jsoncFiles,
	json5Files,
	jstFiles,
	mdFiles,
	ignores
];

export default defineConfig;
