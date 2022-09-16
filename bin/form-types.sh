#!/usr/bin/env bash
set -e

vue-tsc --declaration --emitDeclarationOnly -p packages/forms/
