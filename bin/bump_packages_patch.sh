#!/usr/bin/env bash
set -e

(cd packages/inertia-view && npm version patch)
(cd packages/forms && npm version patch)
(cd packages/elements && npm version patch)
