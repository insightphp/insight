#!/usr/bin/env bash
set -e

(cd packages/inertia-view && rm -f *.tgz && npm pack)
(cd packages/forms && rm -f *.tgz && npm pack)
(cd packages/elements && rm -f *.tgz && npm pack)
