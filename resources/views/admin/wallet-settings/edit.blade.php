@extends('layouts.admin')

@section('title', 'Edit Wallet Setting')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Edit Wallet Setting</h1>
        <a href="{{ route('admin.wallet-settings.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Wallet Settings
        </a>
    </div>

    @if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="fas fa-wallet me-2"></i>{{ ucfirst($walletSetting->cryptocurrency) }} Wallet Settings
            </h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.wallet-settings.update', $walletSetting) }}">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="cryptocurrency" class="form-label">Cryptocurrency</label>
                            <input type="text" class="form-control" id="cryptocurrency" name="cryptocurrency"
                                value="{{ old('cryptocurrency', $walletSetting->cryptocurrency) }}" readonly>
                            <div class="form-text">Cryptocurrency type cannot be changed after creation.</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="currency_name" class="form-label">Currency Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('currency_name') is-invalid @enderror"
                                id="currency_name" name="currency_name"
                                value="{{ old('currency_name', $walletSetting->currency_name) }}" required>
                            @error('currency_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="currency_symbol" class="form-label">Currency Symbol <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('currency_symbol') is-invalid @enderror"
                                id="currency_symbol" name="currency_symbol"
                                value="{{ old('currency_symbol', $walletSetting->currency_symbol) }}"
                                maxlength="10" required>
                            @error('currency_symbol')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">e.g., ₿, Ξ, ₮</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="currency_code" class="form-label">Currency Code <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('currency_code') is-invalid @enderror"
                                id="currency_code" name="currency_code"
                                value="{{ old('currency_code', $walletSetting->currency_code) }}"
                                maxlength="10" required>
                            @error('currency_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">e.g., BTC, ETH, USDT</div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="wallet_address" class="form-label">Wallet Address <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('wallet_address') is-invalid @enderror"
                        id="wallet_address" name="wallet_address" rows="3" required>{{ old('wallet_address', $walletSetting->wallet_address) }}</textarea>
                    @error('wallet_address')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text">Enter the complete wallet address for receiving payments.</div>
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                            {{ old('is_active', $walletSetting->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">
                            Active
                        </label>
                        <div class="form-text">Only active wallets will be available for payments.</div>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.wallet-settings.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times me-2"></i>Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Update Wallet Setting
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Current Wallet Address Display -->
    <div class="card mt-4">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="fas fa-qrcode me-2"></i>Current Wallet Address
            </h5>
        </div>
        <div class="card-body">
            <div class="d-flex align-items-center">
                <code class="flex-grow-1 p-2 bg-light rounded">{{ $walletSetting->wallet_address }}</code>
                <button class="btn btn-outline-primary ms-2" onclick="copyToClipboard('{{ $walletSetting->wallet_address }}')">
                    <i class="fas fa-copy me-1"></i>Copy
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(function() {
            // Show success message
            const toast = document.createElement('div');
            toast.className = 'toast align-items-center text-white bg-success border-0 position-fixed top-0 end-0 m-3';
            toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    Wallet address copied to clipboard!
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        `;
            document.body.appendChild(toast);
            const bsToast = new bootstrap.Toast(toast);
            bsToast.show();
            setTimeout(() => toast.remove(), 3000);
        });
    }
</script>
@endsection