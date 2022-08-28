#!/usr/bin/env bash
set -e

(cd packages/inertia-view-components && rm -f *.tgz && npm pack)
(cd packages/forms && rm -f *.tgz && npm pack)
