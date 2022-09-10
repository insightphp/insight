#!/usr/bin/env bash
set -e

vue-tsc --noEmit -p packages/elements/
(cd packages/elements && npm version patch)
vite build -c packages/elements/vite.config.ts --outDir packages/elements/dist
vue-tsc --declaration --emitDeclarationOnly -p packages/elements/
(cd packages/elements && rm -f *.tgz && npm pack)
(cd packages/elements && npm pack && npm publish --access public && rm *.tgz)
