<?php

namespace App\Enums;

enum ProductFilesStatus: string
{
    case CHUNK_UPLOADED = 'chunk_uploaded';
    case PROCESSING = 'processing';
    case COMPLETED = 'completed';
    case FAILED = 'failed';
    case ALREADY_PROCESSED = 'already_processed';
    case DELETING = 'deleting';

    /**
     * Get human-readable label
     */
    public function label(): string
    {
        return match ($this) {
            self::CHUNK_UPLOADED => 'Chunk Uploaded',
            self::PROCESSING => 'Processing',
            self::COMPLETED => 'Completed',
            self::FAILED => 'Failed',
            self::ALREADY_PROCESSED => 'Already Processed',
            self::DELETING => 'Deleting file',
        };
    }

    /**
     * Get frontend/API response message
     */
    public function message(): string
    {
        return match ($this) {
            self::CHUNK_UPLOADED => 'Chunk uploaded successfully',
            self::PROCESSING => 'File uploaded successfully. Processing started.',
            self::COMPLETED => 'File upload completed successfully',
            self::FAILED => 'File upload failed',
            self::ALREADY_PROCESSED => 'File is already being processed',
            self::DELETING => 'File is deleting, please hold on',
        };
    }
}
