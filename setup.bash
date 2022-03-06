#!/usr/bin/bash
set -e

cd projects

pushd BrainfuckDebugger
npm install
popd


pushd christmas-coloring-book
npm install
npm run build
popd

pushd color-app
npm install
npm run build
popd

pushd smbc-fourier-transform
npm install
npm run build
popd



