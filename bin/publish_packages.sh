#!/usr/bin/env bash
set -e

(cd packages/inertia-view-components && npm pack && npm publish --access public && rm *.tgz)
(cd packages/forms && npm pack && npm publish --access public && rm *.tgz)
