  # TODO: Fix Book Cover Display

**Status:** In Progress

### 1. [ ] Create TODO (Current)
### 2. [ ] Fix resources/views/books/index.blade.php
### 3. [ ] Fix resources/views/buku.blade.php
### 4. [ ] Fix resources/views/books/create.blade.php + edit.blade.php 
### 5. [ ] Test all book pages
### 6. [ ] Complete!

**Problem:** Covers upload OK but not showing (wrong asset path)
**Solution:** Use `asset('storage/' . $book->cover_path)` consistently

**Next:** Fix main books list view

