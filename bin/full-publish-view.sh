#!/usr/bin/env bash
set -e

vue-tsc --noEmit -p packages/inertia-view/
(cd packages/inertia-view && npm version patch)
vite build -c packages/inertia-view/vite.config.ts --outDir packages/inertia-view/dist
vue-tsc --declaration --emitDeclarationOnly -p packages/inertia-view/
(cd packages/inertia-view && rm -f *.tgz && npm pack)
(cd packages/inertia-view && npm pack && npm publish --access public && rm *.tgz)
