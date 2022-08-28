#!/usr/bin/env bash
set -e

# Inertia View Components
vue-tsc --noEmit -p packages/inertia-view-components/
vite build -c packages/inertia-view-components/vite.config.ts --outDir packages/inertia-view-components/dist
vue-tsc --declaration --emitDeclarationOnly -p packages/inertia-view-components/

# Forms
vue-tsc --noEmit -p packages/forms/
vite build -c packages/forms/vite.config.ts --outDir packages/forms/dist
vue-tsc --declaration --emitDeclarationOnly -p packages/forms/
