#!/usr/bin/env bash
set -e

vue-tsc --noEmit -p packages/inertia-view-components/
(cd packages/inertia-view-components && npm version patch)
vite build -c packages/inertia-view-components/vite.config.ts --outDir packages/inertia-view-components/dist
vue-tsc --declaration --emitDeclarationOnly -p packages/inertia-view-components/
(cd packages/inertia-view-components && rm -f *.tgz && npm pack)
(cd packages/inertia-view-components && npm pack && npm publish --access public && rm *.tgz)
