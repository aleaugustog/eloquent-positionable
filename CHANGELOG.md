# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [0.2.0] - 2023-01-18

### Added

-   `setNewOrder` functionality

## [0.1.1] - 2021-12-07

### Changed

-   Fixed required PHP version property in composer.json

## [0.1.0] - 2021-12-06

### Added

-   Automatically assign next available position on create
-   Query by position with `scopePosition()`
-   Query by position between 2 values with `scopePositionBetween()`
-   Sort Eloquent queries by position with `scopeOrdered()`
-   Move a model by indicating the position change relative to the current position with `moveStep()`
-   Move a model by indicating the desired position with `moveTo()`
-   Move a model to the start with `moveToStart()`
-   Move a model to the end with `moveToEnd()`
-   Move a model N places up with `moveUp()`
-   Move a model N places down with `moveDown()`
-   Swap positions between models with `swapPositions()`
