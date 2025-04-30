<div class="mb-3">
    <label for="review-text">Рецензия:</label>
    <textarea id="review-text" class="form-control" rows="5">@if($review){{ $review->text }}@endif</textarea>
    <button class="btn btn-primary mt-2" onclick="submitReview({{ $trackId }})">
        @if($review) Обновить @else Оставить @endif рецензию
    </button>
</div>