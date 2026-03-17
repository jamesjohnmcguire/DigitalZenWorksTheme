#!/usr/bin/env node

const esbuild = require('esbuild');
const fs = require('fs');
const path = require('path');

process.chdir(path.join(__dirname, '..'));

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

// Remove all @charset declarations and let esbuild add it if needed
const cssContent = cssFiles
  .map(f => fs.readFileSync(f, 'utf8'))
  .map(content => content.replace(/@charset\s+["'][^"']+["'];?\s*/gi, ''))
  .join('\n');

  esbuild.buildSync({
  stdin: {
    contents: cssContent,
    loader: 'css',
  },
  minify: true,
  outfile: `${DESTINATION}/css/default.min.css`,
});

const jsContent = jsFiles.map(f => fs.readFileSync(f, 'utf8')).join('\n');
esbuild.buildSync({
  stdin: {
    contents: jsContent,
    loader: 'js',
  },
  minify: true,
  outfile: `${DESTINATION}/js/scripts.min.js`,
});

console.log('Minify complete!');
