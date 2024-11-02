#!/usr/bin/bash
set -e

mkdir -p dist/projects

minijinja-cli -D index_active=active -D content="$(cat snips/index.html)" template.jinja > dist/index.html
minijinja-cli -D projects_active=active -D content="$(cat snips/projects.html)" template.jinja > dist/projects.html
minijinja-cli -D experience_active=active -D content="$(cat snips/experience.html)" template.jinja > dist/experience.html
minijinja-cli -D skills_active=active -D content="$(cat snips/skills.html)" template.jinja > dist/skills.html
minijinja-cli -D content="$(cat snips/error.html)" template.jinja > dist/error.html
cp -r snips/ dist/
cp -r static/ dist/

pushd projects

pushd BrainfuckDebugger
npm install
popd
cp -r BrainfuckDebugger ../dist/projects

pushd christmas-coloring-book
npm install
npm run build
popd
cp -r christmas-coloring-book/dist ../dist/projects/christmas-coloring-book

pushd color-app
npm install
npm run build
popd
cp -r color-app/dist ../dist/projects/color-app

pushd smbc-fourier-transform
npm install
npm run build
popd
cp -r smbc-fourier-transform/dist ../dist/projects/smbc-fourier-transform

pushd its-a-unix-system
wasm-pack build --no-default-features
pushd www
npm install
npm run build
popd
popd
cp -r its-a-unix-system/www/dist ../dist/projects/its-a-unix-system

cp -r animator ../dist/projects/
cp -r capture-go ../dist/projects/
cp -r snake ../dist/projects/

popd
