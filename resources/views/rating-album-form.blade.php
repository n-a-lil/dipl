<div class="mb-3">
    <label for="text-rating">Текст:</label>
    <input type="range" id="text-rating" class="form-range" min="1" max="10" value="5" onchange="updateRating('text')">
    <span id="text-rating-value">5</span>
</div>

<div class="mb-3">
    <label for="structure-rating">Структура:</label>
    <input type="range" id="structure-rating" class="form-range" min="1" max="10" value="5" onchange="updateRating('structure')">
    <span id="structure-rating-value">5</span>
</div>

<div class="mb-3">
    <label for="style-rating">Реализация стиля:</label>
    <input type="range" id="style-rating" class="form-range" min="1" max="10" value="5" onchange="updateRating('style')">
    <span id="style-rating-value">5</span>
</div>

<div class="mb-3">
    <label for="individuality-rating">Индивидуальность:</label>
    <input type="range" id="individuality-rating" class="form-range" min="1" max="10" value="5" onchange="updateRating('individuality')">
    <span id="individuality-rating-value">5</span>
</div>

<div class="mb-3">
    <label for="vibe-rating">Вайб:</label>
    <input type="range" id="vibe-rating" class="form-range" min="1" max="10" value="5" onchange="updateRating('vibe')">
    <span id="vibe-rating-value">5</span>
</div>

<button class="btn btn-primary" onclick="submitAlbumRating()" data-id="{{ $albumId }}">Оценить альбом</button>