#!/usr/bin/env node

import * as esbuild from 'esbuild';
import { promises as fs } from 'fs';
import { join } from 'path';

import { fileURLToPath } from 'url';
import { dirname } from 'path';

async function minfiyCssFiles(cssFiles, minifiedCssFile)
{
	let cssContentRaw = await Promise.all(
		cssFiles.map(f => fs.readFile(f, 'utf8')));

	// Remove all @charset declarations and let esbuild add it if needed
	cssContentRaw = cssContentRaw.map(
		content => content.replace(/@charset\s+["'][^"']+["'];?\s*/gi, ''));

	const cssContent = cssContentRaw.join('\n');

	const stdIn =
	{
		contents: cssContent,
		loader: 'css'
	};

	const parameters =
	{
		stdin: stdIn,
		minify: true,
		outfile: minifiedCssFile
	};

	esbuild.buildSync(parameters);
}

async function minfiyJsFiles(jsFiles, minifiedJsFile)
{
	const jsContentRaw = await Promise.all(
		jsFiles.map(f => fs.readFile(f, 'utf8')));

	const jsContent = jsContentRaw.join('\n');

	const stdIn =
	{
		contents: jsContent,
		loader: 'js',
	};

	const parameters =
	{
		stdin: stdIn,
		minify: true,
		outfile: minifiedJsFile
	};

	esbuild.buildSync(parameters);
}

const __filename = fileURLToPath(import.meta.url);
const __dirname = dirname(__filename);

const joined = join(__dirname, '..');
process.chdir(joined);

const SOURCE = 'SourceCode/assets';
const DESTINATION = 'SourceCode/assets';

const cssFiles =
[
  `${SOURCE}/css/style.css`
];

const jsFiles =
[
  `${SOURCE}/js/customizer.js`,
  `${SOURCE}/js/navigation.js`
];

minfiyCssFiles(cssFiles, `${DESTINATION}/css/default.min.css`);

minfiyJsFiles(jsFiles, `${DESTINATION}/js/scripts.min.js`);

console.log('Minify complete!');
