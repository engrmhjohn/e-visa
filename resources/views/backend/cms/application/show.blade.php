@extends('backend.master')
@section('title')
Admin :: CMS
@endsection
@section('content')
<div class="page-inner mt-5 pt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Add Blog</h4>
                </div>
                <div class="card-body">
                    <button class="btn btn-black btn-sm mb-2" title="Go Back" onclick="history.back();">
                        <span class="btn-label">
                            <i class="fas fa-reply"></i>
                        </span>
                        Go Back
                    </button>
                    <a href="{{ route('manage_blog') }}" class="btn btn-success btn-sm mb-2" title="Manage Blog">
                        <span class="btn-label">
                            <i class="fas fa-wrench"></i>
                        </span>
                        Manage Blog
                    </a>
                    <form action="{{ route('save_blog') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-lg-4">
                                <div class="form-group form-inline">
                                    <label for="blog_image" class="col-md-4 col-form-label fw-bold">Blog Image</label>
                                    <div class="col-md-12">
                                        <input type="file" name="blog_image" id="blog_image" class="dropify" />
                                        @if ($errors->has('blog_image'))
                                        <small class="text-danger d-block mt-1">{{ $errors->first('blog_image') }}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            {{-- Title --}}
                            <div class="col-lg-12 mb-3">
                                <div class="form-group form-inline">
                                    <label for="title" class="col-md-4 col-form-label fw-bold">Blog Title</label>
                                    <div class="col-md-12">
                                        <input type="text" name="title" id="title" class="form-control input-full {{ $errors->has('title') ? 'is-invalid' : '' }}" placeholder="Enter Title" value="{{ old('title', $blog->title ?? '') }}" />
                                        @error('title')
                                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Meta Keyword --}}
                            <div class="col-lg-12 mb-3">
                                <div class="form-group form-inline">
                                    <label for="meta_keyword" class="col-md-4 col-form-label fw-bold">Meta Keyword</label>
                                    <div class="col-md-12">
                                        <input type="text" name="meta_keyword" id="meta_keyword" class="form-control input-full {{ $errors->has('meta_keyword') ? 'is-invalid' : '' }}" placeholder="Enter Meta Keyword" value="{{ old('meta_keyword', $blog->meta_keyword ?? '') }}" />
                                        @error('meta_keyword')
                                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Meta Description --}}
                            <div class="col-lg-12 mb-3">
                                <div class="form-group form-inline">
                                    <label for="meta_description" class="col-md-4 col-form-label fw-bold">Meta Description</label>
                                    <div class="col-md-12">
                                        <textarea name="meta_description" id="meta_description" class="form-control input-full {{ $errors->has('meta_description') ? 'is-invalid' : '' }}" placeholder="Enter Meta Description">{{ old('meta_description', $blog->meta_description ?? '') }}</textarea>
                                        @error('meta_description')
                                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Description --}}
                            <div class="col-lg-12 mb-3">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Blog Description</h4>
                                    </div>
                                    <div class="card-body">
                                        <textarea name="description" id="dark" class="form-control" rows="10">{{ old('description', $blog->description ?? '') }}</textarea>
                                        @error('description')
                                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Status --}}
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="fw-bold">Status</label><br/>
                                    <div class="d-flex gap-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="status" id="status_active" value="active" checked {{ old('status', $data->status ?? '') == 'active' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="status_active">
                                                Active
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="status" id="status_inactive" value="inactive" {{ old('status', $data->status ?? '') == 'inactive' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="status_inactive">
                                                Inactive
                                            </label>
                                        </div>
                                    </div>
                                    @error('status')
                                        <small class="text-danger d-block mt-1">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>

                        </div>
                        <button type="submit" class="btn btn-secondary">Save</button>
                </div>

                </form>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
