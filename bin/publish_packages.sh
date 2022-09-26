#!/usr/bin/env bash
set -e

(cd packages/inertia-view && npm pack && npm publish --access public && rm *.tgz)
(cd packages/forms && npm pack && npm publish --access public && rm *.tgz)
(cd packages/elements && npm pack && npm publish --access public && rm *.tgz)
