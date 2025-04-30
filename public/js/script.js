function loadLibrary() {
    let url = "/library-content"; 
    let request = new XMLHttpRequest();
    request.open("GET", url, true);
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            let response = request.responseText;
            if (response === 'unauthorized') {
                alert('Вы должны быть авторизованы для просмотра библиотеки!');
                return;
            }
            document.getElementById("content").innerHTML = request.responseText;
            updateActiveTab("btn-library");
            initAudioControls();
        }
    };
    request.send();
}

function loadHome() {
    const searchResults = document.getElementById("universal-search-results");
    const searchInput = document.getElementById("universal-search");
    
    if (searchResults) searchResults.innerHTML = "";
    if (searchInput) searchInput.value = "";
    
    let url = "/home-content"; 
    let request = new XMLHttpRequest();
    request.open("GET", url, true);
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            document.getElementById("content").innerHTML = request.responseText;
            updateActiveTab("btn-home");
            initAudioControls();
        }
    };
    request.send();
}

function loadTracks() {
    let url = "/tracks"; 
    let request = new XMLHttpRequest();
    request.open("GET", url, true);
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            document.getElementById("all").innerHTML = request.responseText;
            updateActiveTab("btn-track");
            initAudioControls();
        }
    };
    request.send();
}

function loadArtist(artistId) {
    let url = "/artist/" + artistId; 
    let request = new XMLHttpRequest();
    request.open("GET", url, true);
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            document.getElementById("content").innerHTML = request.responseText;
            loadArtistTracks(artistId);
        }
    };
    request.send();
}

function loadArtistTracks(artistId) {
    let url = `/artist/${artistId}/tracks`;
    let request = new XMLHttpRequest();
    request.open("GET", url, true);
    request.onreadystatechange = function() {
        if (request.readyState === 4 && request.status === 200) {
            document.getElementById("artist-content").innerHTML = request.responseText;
            updateActiveTab("btn-track"); 
            initAudioControls();
        }
    };
    request.send();
}

function loadArtistAlbums(artistId) {
    let url = `/artist/${artistId}/albums`;
    let request = new XMLHttpRequest();
    request.open("GET", url, true);
    request.onreadystatechange = function() {
        if (request.readyState === 4 && request.status === 200) {
            document.getElementById("artist-content").innerHTML = request.responseText;
            updateActiveTab("btn-albums"); 
        }
    };
    request.send();
}

function loadArtistAlbumTracks(albumId, artistId) {
    let url = `/artist/${artistId}/albums/${albumId}/tracks`;
    let request = new XMLHttpRequest();
    request.open("GET", url, true);
    request.onreadystatechange = function() {
        if (request.readyState === 4 && request.status === 200) {
            document.getElementById("artist-content").innerHTML = request.responseText;
            initAudioControls();
        }
    };
    request.send();
}

function backToArtistAlbums(artistId) {
    loadArtistAlbums(artistId);
    updateActiveTab("btn-albums");
}

function openAlbumRatingModal() {
    let url = "/ratingAlbum";
    let request = new XMLHttpRequest();
    request.open("GET", url, true);
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText;
            if (response === 'unauthorized') {
                alert('Вы должны быть авторизованы для того, чтобы оценить альбом!');
                return;
            }
            document.getElementById("content").innerHTML = response;
            updateActiveTab("btn-ratingalbum");
            initAlbumSearch();
        }
    };
    request.send();
}

function initAlbumSearch() {
    let searchInput = document.getElementById("album-search");
    let searchResults = document.getElementById("search-results");
    let selectedAlbumContainer = document.getElementById("selected-album");

    if (!searchInput || !searchResults || !selectedAlbumContainer) {
        console.error("Один из элементов поиска не найден в DOM!");
        return;
    }

    searchInput.addEventListener("input", function () {
        let query = searchInput.value;
        if (query.length < 1) {
            searchResults.innerHTML = "";
            return;
        }

        let request = new XMLHttpRequest();
        request.open("GET", "/search-albums?query=" + encodeURIComponent(query), true);
        request.onreadystatechange = function () {
            if (request.readyState == 4 && request.status == 200) {
                searchResults.innerHTML = request.responseText;
                attachAlbumClickEvents();
            }
        };
        request.send();
    });

    function attachAlbumClickEvents() {
        document.querySelectorAll(".album-item").forEach(function (albumItem) {
            albumItem.addEventListener("click", function () {
                let albumId = albumItem.getAttribute("data-id");
                loadSelectedAlbumForRating(albumId);
            });
        });
    }

    function loadSelectedAlbumForRating(albumId) {
        let request = new XMLHttpRequest();
        request.open("GET", "/selected-album/" + albumId, true);
        request.onreadystatechange = function () {
            if (request.readyState == 4 && request.status == 200) {
                selectedAlbumContainer.innerHTML = request.responseText;
                searchResults.innerHTML = "";
                searchInput.value = "";
                
                loadAlbumRatingForm(albumId);
            }
        };
        request.send();
    }

    function loadAlbumRatingForm(albumId) {
        let request = new XMLHttpRequest();
        request.open("GET", "/rating-album-form/" + albumId, true);
        request.onreadystatechange = function () {
            if (request.readyState == 4 && request.status == 200) {
                document.getElementById("rating-section").innerHTML = request.responseText;
            }
        };
        request.send();
    }
}

function submitAlbumRating() {
    const albumId = document.querySelector("button[data-id]").getAttribute("data-id");
    const ratings = {
        text: document.getElementById("text-rating").value,
        structure: document.getElementById("structure-rating").value,
        style: document.getElementById("style-rating").value,
        individual: document.getElementById("individuality-rating").value,
        vibe: document.getElementById("vibe-rating").value,
    };

    let queryString = `albumId=${albumId}&text=${ratings.text}&structure=${ratings.structure}&style=${ratings.style}&individuality=${ratings.individual}&vibe=${ratings.vibe}`;

    let request = new XMLHttpRequest();
    request.open("GET", "/submit-album-rating?" + queryString, true);
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            alert("Оценка альбома успешно отправлена!");
            loadHome();
        }
    };
    request.send();
}

function openRatingModal() {
    let url = "/ratingTrack";
    let request = new XMLHttpRequest();
    request.open("GET", url, true);
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText;
            if (response === 'unauthorized') {
                alert('Вы должны быть авторизованы для того, чтобы оценить трек!');
                return;
            }
            document.getElementById("content").innerHTML = response;
            updateActiveTab("btn-ratingtrack");
            initAudioControls(); 
            initSearch(); 
        }
    };
    request.send();
}

function initSearch() {
    let searchInput = document.getElementById("track-search");
    let searchResults = document.getElementById("search-results");
    let selectedTrackContainer = document.getElementById("selected-track");

    console.log(searchInput, searchResults, selectedTrackContainer); 

    if (!searchInput || !searchResults || !selectedTrackContainer) {
        console.error("Один из элементов поиска не найден в DOM!");
        return;
    }

    searchInput.addEventListener("input", function () {
        let query = searchInput.value;
        if (query.length < 1) {
            searchResults.innerHTML = "";
            return;
        }

        let request = new XMLHttpRequest();
        request.open("GET", "/search-tracks?query=" + encodeURIComponent(query), true);
        request.onreadystatechange = function () {
            if (request.readyState == 4 && request.status == 200) {
                searchResults.innerHTML = request.responseText;
                attachClickEvents(); 
            }
        };
        request.send();
    });

    function attachClickEvents() {
        document.querySelectorAll(".track-item").forEach(function (trackItem) {
            trackItem.addEventListener("click", function () {
                let trackId = trackItem.getAttribute("data-id");
                loadSelectedTrack(trackId);
            });
        });
    }

    function loadSelectedTrack(trackId) {
        let request = new XMLHttpRequest();
        request.open("GET", "/selected-track/" + trackId, true);
        request.onreadystatechange = function () {
            if (request.readyState == 4 && request.status == 200) {
                selectedTrackContainer.innerHTML = request.responseText;
                searchResults.innerHTML = ""; 
                searchInput.value = ""; 
                
                loadRatingForm(trackId); 
            }
        };
        request.send();
    }

    function loadRatingForm(trackId) {
        let request = new XMLHttpRequest();
        request.open("GET", "/rating-form/" + trackId, true); 
        request.onreadystatechange = function () {
            if (request.readyState == 4 && request.status == 200) {
                document.getElementById("rating-section").innerHTML = request.responseText;
            }
        };
        request.send();
    }
}

function initUniversalSearch() {
    const searchInput = document.getElementById("universal-search");
    const searchResults = document.getElementById("universal-search-results");

    if (!searchInput || !searchResults) {
        console.error("Элементы поиска не найдены!");
        return;
    }

    searchInput.addEventListener("input", function () {
        let query = searchInput.value;
        if (query.length < 1) {
            searchResults.innerHTML = "";
            return;
        }

        const request = new XMLHttpRequest();
        request.open("GET", `/universal-search?query=${encodeURIComponent(query)}`, true);
        
        request.onreadystatechange = function() {
            if (request.readyState === 4) {
                if (request.status === 200) {
                    searchResults.innerHTML = request.responseText;
                    searchResults.style.display = "block";
                    attachClickEvents();
                } else {
                    searchResults.innerHTML = "<div class='p-3 text-muted'>Ошибка при поиске</div>";
                    searchResults.style.display = "block";
                }
            }
        };
        
        request.send();
    });

    function attachClickEvents() {
        document.querySelectorAll(".track-item").forEach(function (trackItem) {
            trackItem.addEventListener("click", function () {
                let trackId = trackItem.getAttribute("data-id");
                loadSelectedTrack(trackId);
            });
        });

        document.querySelectorAll(".artist-item").forEach(function (artistItem){
            artistItem.addEventListener("click", function() {
                let artistId = artistItem.getAttribute("data-id");
                loadSelectedArtist(artistId);
            });
        });

        document.querySelectorAll(".album-item").forEach(function (albumItem) {
            albumItem.addEventListener("click", function() {
                let albumId = albumItem.getAttribute("data-id");
                loadSelectedAlbum(albumId);
            });
        });
    }

    function loadSelectedAlbum(albumId) {
        const request = new XMLHttpRequest();
        request.open("GET", `/selected-album/${albumId}`, true);
        
        request.onreadystatechange = function() {
            if (request.readyState === 4 && request.status === 200) {
                document.getElementById("content").innerHTML = request.responseText;
                searchResults.innerHTML = "";
                searchInput.value = "";
                searchResults.style.display = "none";
                initAudioControls();
            }
        };
        
        request.send();
    }

    function loadSelectedTrack(trackId) {
        const request = new XMLHttpRequest();
        request.open("GET", `/home-selected-track/${trackId}`, true);
        
        request.onreadystatechange = function() {
            if (request.readyState === 4 && request.status === 200) {
                document.getElementById("content").innerHTML = request.responseText;
                searchResults.innerHTML = "";
                searchInput.value = "";
                searchResults.style.display = "none";
                initAudioControls();
            }
        };
        
        request.send();
    }

    function loadSelectedArtist(artistId) {
        const request = new XMLHttpRequest();
        request.open("GET", `/selected-artist/${artistId}`, true);
        
        request.onreadystatechange = function() {
            if (request.readyState === 4 && request.status === 200) {
                document.getElementById("content").innerHTML = request.responseText;
                searchResults.innerHTML = "";
                searchInput.value = "";
                searchResults.style.display = "none";
                initAudioControls();
            }
        };
        
        request.send();
    }
    document.addEventListener("click", function(e) {
        if (!searchResults.contains(e.target) && e.target !== searchInput) {
            searchResults.style.display = "none";
        }
    });
}

function updateRating(ratingType) {
    const ratingValue = document.getElementById(ratingType + "-rating").value;
    document.getElementById(ratingType + "-rating-value").textContent = ratingValue;
}

function submitRating() {
    const trackId = document.querySelector("button[data-id]").getAttribute("data-id");
    const ratings = {
        text: document.getElementById("text-rating").value,
        structure: document.getElementById("structure-rating").value,
        style: document.getElementById("style-rating").value,
        individuality: document.getElementById("individuality-rating").value,
        vibe: document.getElementById("vibe-rating").value,
    };

    let queryString = `trackId=${trackId}&text=${ratings.text}&structure=${ratings.structure}&style=${ratings.style}&individuality=${ratings.individuality}&vibe=${ratings.vibe}`;

    let request = new XMLHttpRequest();
    request.open("GET", "/submit-rating?" + queryString, true); 
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            alert("Оценка успешно отправлена!");
            loadHome(); 
        }
    };

    request.send();
}

function showReviewForm(trackId) {
    let request = new XMLHttpRequest();
    request.open("GET", "/review-form/" + trackId, true); 
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            document.getElementById("review-section").innerHTML = request.responseText;
        }
    };
    request.send();
}

function submitReview(trackId) {
    const reviewText = document.getElementById("review-text").value;
    
    if (!reviewText.trim()) {
        alert("Рецензия не может быть пустой!");
        return;
    }

    const url = `/submit-review?trackId=${trackId}&reviewText=${encodeURIComponent(reviewText)}`;
    
    let request = new XMLHttpRequest();
    request.open("GET", url, true);
    request.onreadystatechange = function() {
        if (request.readyState === 4 && request.status === 200) {
            alert("Изменения сохранены!");
            loadHome();
        }
    };
    request.send();
}

function loadProfile() {
    let request = new XMLHttpRequest();
    request.open("GET", "/profile", true);
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            document.getElementById("content").innerHTML = request.responseText;
        }
    };
    request.send();
}

function loadHistoryTracks() {
    let request = new XMLHttpRequest();
    request.open("GET", "/history", true);
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            let response = request.responseText;

            if (response === 'unauthorized') {
                alert('Вы должны быть авторизованы для просмотра истории прослушиваний!');
                return;
            }

            document.getElementById("content").innerHTML = response;
            updateActiveTab("btn-history");
            initAudioControls(); 
        }
    };
    request.send();
}

function likeReview(reviewId) {
    var request = new XMLHttpRequest();
    request.open('GET', '/reviews/' + reviewId + '/like', true);
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            var response = request.responseText;
            if (response === 'unauthorized') {
                alert('Вы должны быть авторизованы для того, чтобы оценить трек!');
                return;
            }
            if (response === 'review_not_found') {
                alert('Рецензия не найдена!');
                return;
            }
            document.getElementById('like-count-' + reviewId).innerText = response;
        }
    };
    request.send();
}

function addTrackToHistory(trackId) {
    let request = new XMLHttpRequest();
    request.open("GET", "/add-to-history?track_id=" + trackId, true);

    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            let response = request.responseText;

            if (response === 'unauthorized') {
                console.log('Вы должны быть авторизованы для сохранения истории прослушиваний!');
            } else if (response === 'already_exists') {
                console.log('Трек уже есть в истории прослушиваний.');
            } else {
                console.log('Трек успешно добавлен в историю прослушиваний.');
            }
        }
    };

    request.send();
}

function uploadAvatar() {
    const fileInput = document.getElementById("avatar");

    if (!fileInput || !fileInput.files || fileInput.files.length === 0) {
        alert("Файл не выбран.");
        return;
    }

    const formData = new FormData();
    formData.append("avatar", fileInput.files[0]); 

    let request = new XMLHttpRequest();
    request.open("POST", "/profile/upload-avatar", true);

    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            alert("Аватарка успешно загружена!");
            loadProfile(); 
        } else if (request.readyState == 4 && request.status != 200) {
            alert("Ошибка при загрузке аватарки.");
        }
    };

    request.send(formData); 
}

function submitEditProfile() {
    const username = document.getElementById("username").value;
    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;

    if (!username || !email) {
        alert("Имя пользователя и email обязательны!");
        return;
    }

    let url = `/profile/edit?username=${encodeURIComponent(username)}&email=${encodeURIComponent(email)}`;
    if (password) {
        url += `&password=${encodeURIComponent(password)}`;
    }

    let request = new XMLHttpRequest();
    request.open("GET", url, true);
    request.onreadystatechange = function () {
        if (request.readyState === 4 && request.status === 200) {
            alert("Профиль успешно обновлен!");

            const userProfileElement = document.getElementById("user-profile");
            if (userProfileElement) {
                userProfileElement.textContent = `Hello, ${username}!`;
            }

            loadProfile();
        }
    };
    request.send();
}

function deleteProfile() {
    if (!confirm("Вы уверены, что хотите удалить аккаунт? Это действие нельзя отменить!")) {
        return;
    }

    let request = new XMLHttpRequest();
    request.open("GET", "/profile/delete", true);
    request.onreadystatechange = function () {
        if (request.readyState === 4 && request.status === 200) {
            alert("Аккаунт удален!");
            window.location.href = "/"; 
        }
    };
    request.send();
}

function addToLibrary(trackId) {
    let request = new XMLHttpRequest();
    request.open("GET", `/add-to-library/${trackId}`, true);
    request.onreadystatechange = function () {
        if (request.readyState === 4) {
            if (request.status === 403) {
                alert("Вы должны быть авторизованы, чтобы добавить трек в библиотеку!");
            } else if (request.status === 404) {
                alert("Трек не найден!");
            } else if (request.status === 409) {
                alert("Этот трек уже есть в вашей библиотеке!");
            } else if (request.status === 200) {
                alert("Трек успешно добавлен в библиотеку!");
            }
        }
    };
    request.send();
}

function removeFromLibrary(trackId) {
    let request = new XMLHttpRequest();
    request.open("GET", `/remove-from-library/${trackId}`, true);
    request.onreadystatechange = function () {
        if (request.readyState === 4) {
            if (request.status === 403) {
                alert("Вы должны быть авторизованы, чтобы удалить трек из библиотеки!");
            } else if (request.status === 404) {
                alert("Трек не найден!");
            } else if (request.status === 409) {
                alert("Этого трека нет в вашей библиотеке!");
            } else if (request.status === 200) {
                alert("Трек успешно удалён из библиотеки!");
            }
        }
    };
    request.send();
}

function UploadTrack() {
    let request = new XMLHttpRequest();
    request.open("GET", "/uploadtrack", true);
    request.onreadystatechange = function () {
        if (request.readyState === 4 && request.status === 200) {
            document.getElementById("upload").innerHTML = request.responseText;
        }
        updateActiveTab("btn-uploadtrack");
    };
    request.send();
}

function UploadAlbum() {
    let request = new XMLHttpRequest();
    request.open("GET", "/uploadalbum", true);
    request.onreadystatechange = function () {
        if (request.readyState === 4 && request.status === 200) {
            document.getElementById("upload").innerHTML = request.responseText;
        }
        updateActiveTab("btn-uploadalbum");
    };
    request.send();
}

function playlists() {
    let request = new XMLHttpRequest();
    request.open("GET", "/playlists", true);
    request.onreadystatechange = function () {
        if (request.readyState === 4 && request.status === 200) {
            document.getElementById("content").innerHTML = request.responseText;
        }
        updateActiveTab("btn-playlists");
    };
    request.send();
}

function loadPlaylistTracks(playlistId) {
    let url = "/playlists/" + playlistId + "/tracks";
    let request = new XMLHttpRequest();
    request.open("GET", url, true);
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            document.getElementById("content").innerHTML = request.responseText;
            initAudioControls();
        }
    };
    request.send();
}


function albums() {
    let request = new XMLHttpRequest();
    request.open("GET", "/albums", true);
    request.onreadystatechange = function() {
        if (request.readyState === 4 && request.status === 200) {
            document.getElementById("all").innerHTML = request.responseText;
            updateActiveTab("btn-albums");
            initAudioControls();
        }
    };
    request.send();
}


function loadAlbumTracks(albumId) {
    let request = new XMLHttpRequest();
    request.open("GET", `/album/${albumId}/tracks`, true);
    request.onreadystatechange = function() {
        if (request.readyState === 4 && request.status === 200) {
            document.getElementById("all").innerHTML = request.responseText;
            updateActiveTab("btn-albums");
            initAudioControls();
        }
    };
    request.send();
}

function loadMyAlbumTracks(albumId) {
    let request = new XMLHttpRequest();
    request.open("GET", `/my/album/${albumId}/tracks`, true);
    request.onreadystatechange = function() {
        if (request.readyState === 4 && request.status === 200) {
            document.getElementById("my").innerHTML = request.responseText;
            updateActiveTab("btn-myalbum");
            initAudioControls();
        }
    };
    request.send();
}

function loadTrackCard(trackId) {
    let request = new XMLHttpRequest();
    request.open("GET", `/track/${trackId}/card`, true);
    request.onreadystatechange = function() {
        if (request.readyState === 4 && request.status === 200) {
            document.getElementById("content").innerHTML = request.responseText;
            initAudioControls();
        }
    };
    request.send();
}

function loadAlbumCard(albumId) {
    let request = new XMLHttpRequest();
    request.open("GET", `/album/${albumId}/card`, true);
    request.onreadystatechange = function() {
        if (request.readyState === 4 && request.status === 200) {
            document.getElementById("content").innerHTML = request.responseText;
            initAudioControls();
        }
    };
    request.send();
}

function loadArtistRatings(artistId) {
    let request = new XMLHttpRequest();
    request.open("GET", `/artist/${artistId}/ratings`, true);
    request.onreadystatechange = function() {
        if (request.readyState === 4 && request.status === 200) {
            document.getElementById("content").innerHTML = request.responseText;
        }
    };
    request.send();
}

function backToAlbums() {
    albums();
}

function backToMyAlbums() {
    MyAlbum(); 
}

function MyTrack() {
    let request = new XMLHttpRequest();
    request.open("GET", "/mytrack", true);
    request.onreadystatechange = function () {
        if (request.readyState === 4 && request.status === 200) {

            document.getElementById("my").innerHTML = request.responseText;
        }
        updateActiveTab("btn-mytrack");
        initAudioControls();
    };
    request.send();
}

function MyAlbum() {
    currentAlbumContext = 'my';
    let request = new XMLHttpRequest();
    request.open("GET", "/myalbum", true);
    request.onreadystatechange = function() {
        if (request.readyState === 4 && request.status === 200) {
            document.getElementById("my").innerHTML = request.responseText;
            updateActiveTab("btn-myalbum");
            initAudioControls();
        }
    };
    request.send();
}

function MyRatingTracks() {
    let request = new XMLHttpRequest();
    request.open("GET", "/myratingtracks", true);
    request.onreadystatechange = function () {
        if (request.readyState === 4 && request.status === 200) {
            document.getElementById("my").innerHTML = request.responseText;
            updateActiveTab("btn-myratingtracks");
            initAudioControls();
        }
    };
    request.send();
}

function addTrack() {
    let form = document.getElementById("uploadForm");
    let formData = new FormData(form);
    
    let xhr = new XMLHttpRequest();
    xhr.open('POST', '/addtrack', true);
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            let responseDiv = document.getElementById("uploadStatus");
            if (xhr.status === 200) {
                responseDiv.innerHTML = `<p class="text-success">Трек успешно загружен!</p>`;
                form.reset();
            } else {
                responseDiv.innerHTML = `<p class="text-danger">Ошибка: ${xhr.responseText || 'Неизвестная ошибка'}</p>`;
            }
        }
    };
    
    xhr.send(formData);
}

function addAlbum() {
    let form = document.getElementById("uploadAlbumForm");
    let formData = new FormData(form);
    
    let xhr = new XMLHttpRequest();
    xhr.open('POST', '/addalbum', true);
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            let responseDiv = document.getElementById("uploadAlbumStatus");
            if (xhr.status === 200) {
                responseDiv.innerHTML = `<p class="text-success">Альбом успешно загружен!</p>`;
                form.reset();
            } else {
                responseDiv.innerHTML = `<p class="text-danger">Ошибка: ${xhr.responseText || 'Неизвестная ошибка'}</p>`;
            }
        }
    };
    
    xhr.send(formData);
}

function deleteTrack(trackId) {
    if (!confirm('Вы уверены, что хотите удалить этот трек?')) {
        return;
    }

    let request = new XMLHttpRequest();
    request.open("GET", `/delete-track/${trackId}`, true);

    request.onreadystatechange = function () {
        if (request.readyState === 4 && request.status === 200) {
            let response = JSON.parse(request.responseText);

            if (response.message === 'Трек успешно удален.') {
                alert('Трек успешно удален.');
            } else if (response.message === 'unauthorized') {
                alert('Вы должны быть авторизованы для удаления трека.');
            } else if (response.message === 'user_not_found') {
                alert('Пользователь не найден.');
            } else if (response.message === 'track_not_found') {
                alert('Трек не найден.');
            } else if (response.message === 'forbidden') {
                alert('Вы не можете удалить этот трек.');
            } else {
                alert('Произошла ошибка при удалении трека.');
            }
            MyTrack(); 
        }
    };

    request.send();
}

function removeTrack(playlistId, trackId) {
    if (!confirm('Вы уверены, что хотите удалить этот трек из плейлиста?')) {
        return;
    }

    let url = '/playlists/' + playlistId + '/remove-track/' + trackId;
    let request = new XMLHttpRequest();
    request.open('GET', url, true);
    
    request.onreadystatechange = function() {
        if (request.readyState == 4) {
            if (request.status == 200) {
                let trackElement = document.querySelector('.playlist-track-item[data-track-id="' + trackId + '"]');
                if (trackElement) {
                    trackElement.remove();
                }
            } else {
                alert('Ошибка при удалении трека');
            }
        }
    };
    
    request.send();
}

function showPlaylistSelection(trackId) {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '/playlist-selection/' + trackId, true);
    
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                var temp = document.createElement('div');
                temp.innerHTML = xhr.responseText;
                document.body.appendChild(temp.firstChild);
                setupModalHandlers();
            }
        }
    };
    xhr.send();
}

function setupModalHandlers() {
    var modal = document.getElementById('playlistModal');
    if (!modal) return;

    var closeBtn = modal.querySelector('.js-close-modal');
    if (closeBtn) {
        closeBtn.addEventListener('click', function() {
            if (modal && modal.parentNode) {
                modal.parentNode.removeChild(modal);
            }
        });
    }

    var playlistButtons = modal.querySelectorAll('.js-select-playlist');
    for (var i = 0; i < playlistButtons.length; i++) {
        playlistButtons[i].addEventListener('click', function() {
            var playlistId = this.getAttribute('data-playlist');
            var trackId = this.getAttribute('data-track');
            addTrackToPlaylist(playlistId, trackId);
        });
    }

    modal.addEventListener('click', function(event) {
        if (event.currentTarget === modal && modal.parentNode) {
            modal.parentNode.removeChild(modal);
        }
    });
}

function addTrackToPlaylist(playlistId, trackId) {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '/playlists/' + playlistId + '/add-track/' + trackId, true);
    
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                alert('Трек успешно добавлен в плейлист!');
                var modal = document.getElementById('playlistModal');
                if (modal) document.body.removeChild(modal);
            } else {
                alert(xhr.status === 409 ? 
                    'Этот трек уже есть в плейлисте' : 
                    'Произошла ошибка при добавлении');
            }
        }
    };
    xhr.send();
}


function showCreatePlaylistForm() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '/playlists/create-form', true);
    
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            document.getElementById('content').innerHTML = xhr.responseText;
        }
    };
    xhr.send();
}

function showAll() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '/all', true);
    
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            document.getElementById('content').innerHTML = xhr.responseText;
            loadTracks();
            updateActiveTab("btn-all", "btn-track"); 
        }
    };
    xhr.send();
}

function showUpload() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '/upload', true);
    
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            document.getElementById('content').innerHTML = xhr.responseText;
            UploadTrack();
            updateActiveTab("btn-upload", "btn-uploadtrack");
        }
    };
    xhr.send();
}

function My() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '/my', true);
    
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            document.getElementById('content').innerHTML = xhr.responseText;
        }
        MyTrack();
        updateActiveTab("btn-my","btn-mytrack");
    };
    xhr.send();
}


function createPlaylist() {
    var name = document.getElementById('playlist-name').value;
    var imageFile = document.getElementById('playlist-image').files[0];
    
    if (!name) {
        alert('Введите название плейлиста');
        return;
    }

    var formData = new FormData();
    formData.append('name', name);
    if (imageFile) {
        formData.append('image', imageFile);
    }

    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/playlists/create', true);
    
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                playlists(); 
            } else {
                alert('Ошибка при создании плейлиста');
            }
        }
    };
    xhr.send(formData);
}

function deletePlaylist(event, playlistId) {
    event.stopPropagation();
    
    if (!confirm('Вы уверены, что хотите удалить этот плейлист?')) {
        return;
    }

    var xhr = new XMLHttpRequest();
    xhr.open('GET', '/playlists/delete/' + playlistId, true);
    
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                var playlistElement = document.querySelector('.playlist-entry[data-id="' + playlistId + '"]');
                if (playlistElement) {
                    setTimeout(function() {
                        playlistElement.remove();
                    }, 300);
                }
            } else {
                alert('Ошибка при удалении плейлиста');
            }
        }
    };
    xhr.send();
}

function showEditPlaylistForm(playlistId) {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '/playlists/' + playlistId + '/edit-form', true);
    
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                document.getElementById('edit-playlist-form-container').innerHTML = xhr.responseText;
                document.getElementById('editPlaylistModal').style.display = 'flex';
            } else {
                alert('Ошибка при загрузке формы');
            }
        }
    };
    xhr.send();
}

function hideEditModal() {
    document.getElementById('editPlaylistModal').style.display = 'none';
}

function setupEditForm(playlistId) {
    var form = document.getElementById('editPlaylistForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            updatePlaylist(playlistId);
        });
    }
}

function updatePlaylist(playlistId) {
    var form = document.getElementById('editPlaylistForm');
    var formData = new FormData(form);
    
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/playlists/' + playlistId + '/update', true);
    
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                hideEditModal();
                playlists(); 
            } else {
                alert('Ошибка при сохранении');
            }
        }
    };
    
    xhr.send(formData);
}

function toggleActions(event, menuId) {
    event.stopPropagation(); 
    const menu = document.getElementById(menuId);
    const allMenus = document.querySelectorAll('.actions-menu');
    
    allMenus.forEach(m => {
        if (m.id !== menuId) m.style.display = 'none';
    });
    
    menu.style.display = menu.style.display === 'block' ? 'none' : 'block';

    document.addEventListener('click', function() {
        document.querySelectorAll('.actions-menu').forEach(menu => {
            menu.style.display = 'none';
        });
    });
}


function updateActiveTab(activeButtonId) {
    let buttons = document.querySelectorAll(".btn");
    buttons.forEach(btn => {
        btn.classList.remove("btn-primary");
        btn.classList.add("btn-secondary");
    });

    let activeButton = document.getElementById(activeButtonId);
    if (activeButton) {
        activeButton.classList.remove("btn-secondary");
        activeButton.classList.add("btn-primary");
    }
}

let currentAudio = null;
let currentTrack = null;
let allTracks = [];
let progressInterval = null;
let albumTracksQueue = []; 
let currentAlbumTrackIndex = 0; 
let isPlayingAlbum = false;

function initAudioControls() {
  allTracks = document.querySelectorAll('.track-card');
  
  for (let i = 0; i < allTracks.length; i++) {
    allTracks[i].querySelector('.btn-play').onclick = function() {
      isPlayingAlbum = false;
      playTrack(allTracks[i]);
    };
  }

  const albumPlayButtons = document.querySelectorAll('.btn-play-album');
  for (let i = 0; i < albumPlayButtons.length; i++) {
    albumPlayButtons[i].onclick = function(e) {
      playFirstTrackOfAlbum(e);
    };
  }

  document.getElementById('play-btn').onclick = togglePlay;
  document.getElementById('prev-btn').onclick = playPrevious;
  document.getElementById('next-btn').onclick = playNext;
}

function playTrack(trackElement) {
  const audioSrc = trackElement.getAttribute('data-src');
  if (!audioSrc) return;

  if (currentAudio) {
    currentAudio.pause();
    clearInterval(progressInterval);
  }

  currentAudio = new Audio(audioSrc);
  currentTrack = trackElement;
  isPlayingAlbum = false;

  updatePlayerUI(
    trackElement.getAttribute('data-cover'),
    trackElement.getAttribute('data-title'),
    trackElement.getAttribute('data-artist')
  );

  progressInterval = setInterval(updateProgress, 1000);

  currentAudio.onended = function() {
    if (isPlayingAlbum) {
      playNextAlbumTrack();
    } else {
      playNext();
    }
  };

  currentAudio.play().catch(e => console.log('Ошибка воспроизведения:', e));
  addTrackToHistory(trackElement.getAttribute('data-id'));
}

function playFirstTrackOfAlbum(event, albumId = null) {
    event.stopPropagation();
    
    const albumCard = albumId ? event.target.closest(`.album-card[data-id="${albumId}"]`) : event.target.closest('.album-card');
    
    if (!albumCard) return;
  
    const finalAlbumId = albumId || albumCard.getAttribute('data-id');
    
    const xhr = new XMLHttpRequest();
    xhr.open('GET', `/album/${finalAlbumId}/tracks-data`, true);
    xhr.onload = function() {
      if (xhr.status === 200) {
        const tracks = JSON.parse(xhr.responseText);
        if (tracks.length > 0) {
          albumTracksQueue = tracks;
          currentAlbumTrackIndex = 0;
          isPlayingAlbum = true;
          playAlbumTrack(albumTracksQueue[currentAlbumTrackIndex]);
        }
      }
    };
    xhr.send();
  }

function playAlbumTrack(track) {
  if (currentAudio) {
    currentAudio.pause();
    clearInterval(progressInterval);
  }

  currentAudio = new Audio(track.file_path);
  currentTrack = null;

  updatePlayerUI(track.image, track.title, track.artist_name);

  progressInterval = setInterval(updateProgress, 1000);

  currentAudio.onended = function() {
    playNextAlbumTrack();
  };

  currentAudio.play().catch(e => console.log('Ошибка воспроизведения:', e));
  addTrackToHistory(track.id);
}

function playNextAlbumTrack() {
  currentAlbumTrackIndex++;
  if (currentAlbumTrackIndex >= albumTracksQueue.length) {
    currentAlbumTrackIndex = 0;
  }
  playAlbumTrack(albumTracksQueue[currentAlbumTrackIndex]);
}

function playPreviousAlbumTrack() {
  currentAlbumTrackIndex--;
  if (currentAlbumTrackIndex < 0) {
    currentAlbumTrackIndex = albumTracksQueue.length - 1; 
  }
  playAlbumTrack(albumTracksQueue[currentAlbumTrackIndex]);
}

function updatePlayerUI(coverSrc, title, artist) {
  document.getElementById('mini-cover').src = coverSrc;
  document.getElementById('mini-title').textContent = title;
  document.getElementById('mini-artist').textContent = artist;
  document.getElementById('mini-player').style.display = 'block';
  document.getElementById('play-btn').textContent = '⏸';
}

function updateProgress() {
  if (currentAudio && currentAudio.duration) {
    const progress = (currentAudio.currentTime / currentAudio.duration) * 100;
    document.querySelector('.progress-bar').style.width = progress + '%';
  }
}

function togglePlay() {
  if (!currentAudio) return;
  
  if (currentAudio.paused) {
    currentAudio.play();
    document.getElementById('play-btn').textContent = '⏸';
  } else {
    currentAudio.pause();
    document.getElementById('play-btn').textContent = '▶';
  }
}

function playNext() {
  if (isPlayingAlbum && albumTracksQueue.length > 0) {
    playNextAlbumTrack();
  } else {
    const currentIndex = findCurrentIndex();
    if (currentIndex === -1) return;
    
    const nextIndex = (currentIndex + 1) % allTracks.length;
    playTrack(allTracks[nextIndex]);
  }
}

function playPrevious() {
  if (isPlayingAlbum && albumTracksQueue.length > 0) {
    playPreviousAlbumTrack();
  } else {
    const currentIndex = findCurrentIndex();
    if (currentIndex === -1) return;
    
    const prevIndex = (currentIndex - 1 + allTracks.length) % allTracks.length;
    playTrack(allTracks[prevIndex]);
  }
}

function findCurrentIndex() {
  for (let i = 0; i < allTracks.length; i++) {
    if (allTracks[i] === currentTrack) return i;
  }
  return -1;
}

document.addEventListener('DOMContentLoaded', function() {
  loadHome();
  initUniversalSearch();
});