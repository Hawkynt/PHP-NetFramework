# Agent guide — PHP-NetFramework

Working agreement for **all** coding agents and human contributors working in
this repository. These rules are not optional. The full house spec lives in
the `Hawkynt/project-template` repo (`STANDARD.md`); this file is the
per-repo distillation.

## What this is

A **pure-PHP clone of the .NET BCL**: one `System.*.php` file per namespace
area, tests under `tests/` driven by `tests/TestRunner.php` (plus
`syntax_check.php`). Sister project of `Perl-NetFramework`.

## Commits

- **Group changes semantically/logically** — one type/namespace concern per
  commit.
- **Every subject line starts with a prefix**: `+` added · `-` removed ·
  `*` changed · `#` bug fixed · `!` critical todo.
- Never start a subject with "fix"/"bugfix"/"changed"/"modified".
- **No AI traces anywhere**: no `Co-Authored-By` AI lines, no "Generated
  with" footers, no agent mentions in messages, comments, or authorship.

## The loop (always, in this order)

1. **Before committing**: `php -l` every touched file and run
   `php tests/TestRunner.php` until green (what CI runs). Update the
   README's structure/usage sections when the public surface changes.
2. **Commit** (rules above) and **push**.
3. **Wait for CI** and fix until green. A pushed change isn't done while the
   workflow it triggered is red.

## Code conventions

- Mirror .NET naming for the public surface (PascalCase classes/methods),
  PHP conventions for internals; guard clauses over deep nesting.
- One namespace area per `System.*.php` file — follow the existing split.
- Keep behavior parity with the Perl sibling where both implement the same
  BCL type; divergence gets a comment saying why.

## README & repo conventions

- Standard frame: title → badges → one-line `>` blockquote (no `## Overview`
  header — the blockquote is the intro); fixed emoji mapping for the
  standard sections (`## ✨ Features`, `## 🚀 Usage Examples`,
  `## 📦 Installation and Dependencies`, `## ❤️ Support`, `## 📜 License`);
  `## 🆘 Getting Help` stays distinct from the funding section.
- License is LGPL-3.0-or-later; the `## ❤️ Support` section and
  `.github/FUNDING.yml` stay intact.
