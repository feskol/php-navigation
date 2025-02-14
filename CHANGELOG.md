# Changelog

## 2.0.1 - (2025-02-14)

- `LinkInterface` now extends `HyperLinkInterface`

## 2.0.0 - (2025-02-13)

**⚠ Behavior Change: ⚠**  
Refactored the Active-Status propagation. Previously, active status was propagated upwards—meaning if a child link was
active, its parent was also considered active. This behavior made it difficult to determine which link was actually
active, as multiple links could appear active simultaneously.

To resolve this issue, only links explicitly marked as active using the `setIsActive()` method will now have an active
status of `true`. However, to maintain the ability to check if a navigation contains active links, a new
`hasActiveChildren()` method has been introduced.

- Added `hasActiveChildren()` method to `Link`: Allows checking if a link has active children.
- Added `setTargetBlank()` method to `Link`: Common use
- `LinkInterface` now extends `HierarchicalLinkInterface`

## 1.0.0

- First release