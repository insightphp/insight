#!/usr/bin/env bash
set -e

# Inertia View Components
vue-tsc --noEmit -p packages/inertia-view/
vite build -c packages/inertia-view/vite.config.ts --outDir packages/inertia-view/dist
vue-tsc --declaration --emitDeclarationOnly -p packages/inertia-view/

# Elements
vue-tsc --noEmit -p packages/elements/
vite build -c packages/elements/vite.config.ts --outDir packages/elements/dist
vue-tsc --declaration --emitDeclarationOnly -p packages/elements/


# Forms
vue-tsc --noEmit -p packages/forms/
vite build -c packages/forms/vite.config.ts --outDir packages/forms/dist
vue-tsc --declaration --emitDeclarationOnly -p packages/forms/
