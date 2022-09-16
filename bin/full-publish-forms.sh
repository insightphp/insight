#!/usr/bin/env bash
set -e

vue-tsc --noEmit -p packages/forms/
(cd packages/forms && npm version patch)
vite build -c packages/forms/vite.config.ts --outDir packages/forms/dist
vue-tsc --declaration --emitDeclarationOnly -p packages/forms/
(cd packages/forms && rm -f *.tgz && npm pack)
(cd packages/forms && npm pack && npm publish --access public && rm *.tgz)
