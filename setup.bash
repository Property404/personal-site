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

cp -r animator ../dist/projects/
cp -r capture-go ../dist/projects/
cp -r snake ../dist/projects/

popd

mkdir -p dist/projects/its-a-unix-system
pushd dist/projects/its-a-unix-system
wget https://github.com/Property404/its-a-unix-system/releases/download/0.1.1/its-a-unix-system.tar.gz
tar xf its-a-unix-system.tar.gz
rm its-a-unix-system.tar.gz
popd
