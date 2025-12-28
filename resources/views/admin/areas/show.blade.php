@extends('layouts.app')

@section('content')
   <div class="container py-4">
    <div class="row">
        <div class="col-md-12">
            <!-- Header Section -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="mb-1">{{ $area->name }}</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.areas.list') }}">{{ __('Areas') }}</a></li>
                            <li class="breadcrumb-item active">{{ $area->name }}</li>
                        </ol>
                    </nav>
                </div>
                <div>
                    <a href="{{ route('admin.areas.list') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i>{{ __('Back') }}
                    </a>
                    @if(auth()->user()->can('edit', $area))
                        <a href="{{ route('admin.areas.edit', $area->id) }}" class="btn btn-primary">
                            <i class="bi bi-pencil me-1"></i>{{ __('Edit Area') }}
                        </a>
                    @endif
                </div>
            </div>

            <!-- Main Card -->
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">{{ __('Area Information') }}</h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <!-- Description -->
                        <div class="col-12">
                            <div class="border-start border-primary border-4 ps-3">
                                <label class="text-muted small mb-1">{{ __('Description') }}</label>
                                <p class="mb-0">{{ $area->description ?: __('No description available') }}</p>
                            </div>
                        </div>

                        <!-- Manager -->
                        <div class="col-md-6">
                            <label class="text-muted small mb-1">{{ __('Manager') }}</label>
                            <div class="d-flex align-items-center">
                                @if($area->manager)
                                    <div class="avatar-circle bg-primary text-white me-2">
                                        {{ substr($area->manager->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="mb-0 fw-semibold">{{ $area->manager->name }}</p>
                                        @if($area->manager->email)
                                            <small class="text-muted">{{ $area->manager->email }}</small>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-muted">{{ __('N/A') }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Parent Area -->
                        <div class="col-md-6">
                            <label class="text-muted small mb-1">{{ __('Parent Area') }}</label>
                            <div>
                                @if($area->parent)
                                    <a href="{{ route('admin.areas.show', $area->parent->id) }}" class="text-decoration-none">
                                        <i class="bi bi-folder me-1"></i>{{ $area->parent->name }}
                                    </a>
                                @else
                                    <span class="text-muted">{{ __('Root Level') }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="col-md-6">
                            <label class="text-muted small mb-1">{{ __('Status') }}</label>
                            <div>
                                @if($area->status)
                                    <span class="badge bg-success-subtle text-success">
                                        <i class="bi bi-check-circle me-1"></i>{{ __('Active') }}
                                    </span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger">
                                        <i class="bi bi-x-circle me-1"></i>{{ __('Inactive') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Created/Updated Info -->
                        <div class="col-md-6">
                            <label class="text-muted small mb-1">{{ __('Created') }}</label>
                            <div>
                                <small class="text-muted">
                                    <i class="bi bi-calendar me-1"></i>{{ $area->created_at->format('M d, Y - h:i A') }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sub-areas Section (if applicable) -->
            @if($area->children && $area->children->count() > 0)
                <div class="card shadow-sm mt-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0">{{ __('Sub-areas') }} <span class="badge bg-primary">{{ $area->children->count() }}</span></h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            @foreach($area->children as $child)
                                <div class="col-md-6 col-lg-4">
                                    <div class="border rounded p-3 h-100 hover-shadow">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h6 class="mb-0">
                                                <a href="{{ route('admin.areas.show', $child->id) }}" class="text-decoration-none">
                                                    {{ $child->name }}
                                                </a>
                                            </h6>
                                            @if($child->status)
                                                <span class="badge bg-success-subtle text-success badge-sm">{{ __('Active') }}</span>
                                            @endif
                                        </div>
                                        @if($child->description)
                                            <p class="text-muted small mb-0">{{ Str::limit($child->description, 80) }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .avatar-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 1.1rem;
    }

    .hover-shadow {
        transition: box-shadow 0.3s ease;
    }

    .hover-shadow:hover {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }

    .badge-sm {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
    }

    .bg-success-subtle {
        background-color: #d1e7dd;
    }

    .text-success {
        color: #0f5132 !important;
    }

    .bg-danger-subtle {
        background-color: #f8d7da;
    }

    .text-danger {
        color: #842029 !important;
    }
</style>
@endsection