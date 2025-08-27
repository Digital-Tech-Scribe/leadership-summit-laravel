<?php

namespace App\Traits;

trait ReusableId
{
    /**
     * Boot the trait and set up event listeners
     */
    protected static function bootReusableId()
    {
        // When creating a new record, try to reuse the lowest available ID
        static::creating(function ($model) {
            if (!$model->getKey()) {
                $model->setAttribute($model->getKeyName(), static::getNextAvailableId());
            }
        });
    }

    /**
     * Get the next available ID by finding gaps in the sequence
     */
    public static function getNextAvailableId()
    {
        $table = (new static)->getTable();
        $keyName = (new static)->getKeyName();

        // Get all existing IDs in ascending order
        $existingIds = static::orderBy($keyName)->pluck($keyName)->toArray();

        // If no records exist, start with 1
        if (empty($existingIds)) {
            return 1;
        }

        // Find the first gap in the sequence
        $expectedId = 1;
        foreach ($existingIds as $id) {
            if ($id != $expectedId) {
                return $expectedId;
            }
            $expectedId++;
        }

        // If no gaps found, return the next sequential ID
        return $expectedId;
    }

    /**
     * Reset auto-increment to the next available ID after deletion
     */
    public static function resetAutoIncrement()
    {
        $table = (new static)->getTable();
        $keyName = (new static)->getKeyName();

        $maxId = static::max($keyName) ?? 0;
        $nextId = $maxId + 1;

        // Reset auto-increment value based on database driver
        $driver = \DB::getDriverName();

        try {
            switch ($driver) {
                case 'mysql':
                    \DB::statement("ALTER TABLE {$table} AUTO_INCREMENT = {$nextId}");
                    break;
                case 'pgsql':
                    \DB::statement("SELECT setval(pg_get_serial_sequence('{$table}', '{$keyName}'), {$maxId})");
                    break;
                case 'sqlite':
                    // SQLite doesn't support resetting auto-increment in the same way
                    // The AUTOINCREMENT behavior will continue from the highest value
                    // This is acceptable for SQLite as it maintains uniqueness
                    break;
                default:
                    // For other databases, skip the reset
                    break;
            }
        } catch (\Exception $e) {
            // If resetting auto-increment fails, log it but don't break the application
            \Log::warning("Failed to reset auto-increment for table {$table}: " . $e->getMessage());
        }
    }

    /**
     * Override the delete method to reset auto-increment after deletion
     */
    public function delete()
    {
        $result = parent::delete();

        if ($result) {
            static::resetAutoIncrement();
        }

        return $result;
    }
}
