@extends('layouts.blog')

@section('title', 'Service Desk')

@section('content')
    <div class="container mt-4 mb-3">
        <h2 style="text-align: center">Service Desk</h2>
        <hr>
        <div class="card my-4" style="border: 2px solid #e2e8f0; border-radius: 20px; padding: 20px;">
            <strong>Silahkan isikan pertanyaan anda dengan mengisi form dibawah.</strong>
            <hr>

            @if (session('success'))
                <script>
                    Swal.fire("Success!", "{{ session('success') }}", "success");
                </script>
            @endif

            @if ($errors->any())
                <script>
                    @foreach ($errors->all() as $error)
                        Swal.fire("Error!", "{{ $error }}", "error");
                    @endforeach
                </script>
            @endif

            <form action="{{ route('service-desk.store') }}" method="POST">
                @csrf
                <div class="form-group text-left">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" class="form-control"
                        value="{{ Auth::check() ? Auth::user()->email : '' }}" placeholder="Masukkan email Anda..." readonly
                        required>
                </div>
                <div class="form-group text-left">
                    <label for="name">Nama:</label>
                    <input type="text" id="name" name="name" class="form-control"
                        placeholder="Masukkan nama Anda..." required>
                </div>
                <div class="form-group text-left">
                    <label for="phone">Telepon:</label>
                    <input type="tel" id="phone" name="phone" class="form-control"
                        placeholder="Masukkan nomor telepon Anda..." max="13" required>
                </div>
                <div class="form-group text-left">
                    <label for="question">Pertanyaan:</label>
                    <textarea id="question" name="question" rows="4" class="form-control"
                        placeholder="Tulis pertanyaan Anda di sini..." required></textarea>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary mt-3">Submit</button>
                </div>
            </form>
        </div>

        <h2 class="mt-5">Pertanyaan yang Diajukan?</h2>
        <!-- Question Section -->
        @foreach ($questions as $question)
            <div class="card mb-4" style="background-color: rgb(243, 240, 240); border-radius: 20px">
                <div class="card-body">
                    <p>{{ $question->question }}</p>
                    <hr>
                    <div class="comment-container container-fluid">
                        <i class="far fa-user mx-2" style="margin-top: -0.16rem;"></i>
                        <strong>{{ $question->name }} - {{ $question->email }}</strong>
                        <br>
                        <i class="far fa-calendar mx-2 fa-xs text-body" style="margin-top: -0.16rem;"></i>
                        <small>{{ $question->updated_at }}</small>
                        <br>
                        <i class="far fa-calendar mx-2 fa-xs text-body" style="margin-top: -0.16rem;"></i>
                        <small>{{ $question->helpful }}</small>
                    </div>

                    @if (Auth::check())
                        <!-- Edit and Delete Buttons -->
                        <div class="float-right">
                            <div class="row">
                                <div class="mr-2">
                                    @if (!$question->helpfulGivenByUser(Auth::id()))
                                        <button type="button" style="width: 35px; height: 35px;"
                                            class="btn btn-sm btn-secondary btn-bantu"
                                            data-question-id="{{ $question->id }}">
                                            <i class="fas fa-thumbs-up"></i>
                                        </button>
                                    @else
                                        <button type="button" style="width: 65px; height: 35px;"
                                            class="btn btn-sm btn-secondary btn-batal-bantu"
                                            data-question-id="{{ $question->id }}">
                                            <strong>Batal</strong>
                                        </button>
                                    @endif
                                </div>
                                <div>
                                    @if (Auth::user()->email == $question->email ||
                                            Auth::user()->hasRole('Admin') ||
                                            Auth::user()->hasRole('Manajer Konten'))
                                        <form id="delete-question-{{ $question->id }}" method="post"
                                            action="{{ route('service-desk.destroy', $question->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" style="width: 35px; height: 35px;"
                                                class="btn btn-sm btn-danger"
                                                onclick="confirmDeleteQuestion('{{ $question->id }}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            @if (Auth::user()->email == $question->email)
                                                <button type="button" style="width: 35px; height: 35px;"
                                                    class="btn btn-sm btn-info"
                                                    onclick="toggleEditForm('question', {{ $question->id }})">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            @endif
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Edit Question Form -->
                        <form id="edit-question-form-{{ $question->id }}" method="post"
                            action="{{ route('service-desk.update', $question->id) }}" style="display: none;">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <textarea class="form-control" name="question" rows="3" required>{{ $question->question }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Perbarui</button>
                            <button type="button" class="btn btn-secondary"
                                onclick="toggleEditForm('question', {{ $question->id }})">Batal</button>
                        </form>
                    @endif

                    <br>
                    <hr style="border: none; border-top: 1px ; margin: 20px 0;">
                    <hr>

                    <p style="font-weight: bold; font-size: 24px">Balasan Komentar</p>
                    <!-- Kolom Balasan -->
                    @if ($question->replies)
                        <!-- Loop untuk menampilkan balasan -->
                        @foreach ($question->replies as $reply)
                            <div class="card mb-2" style="background-color: rgb(252, 223, 223); border-radius: 20px">
                                <div class="card-body">
                                    <p>{{ $reply->reply }}</p>
                                    <hr>

                                    <!-- Meta Information -->
                                    <div class="comment-container container-fluid">
                                        <i class="far fa-user mx-2" style="margin-top: -0.16rem;"></i>
                                        <strong>{{ $reply->email }}</strong>
                                        <br>
                                        <i class="far fa-calendar mx-2 fa-xs text-body" style="margin-top: -0.16rem;"></i>
                                        <small>{{ $reply->updated_at }}</small>
                                    </div>
                                    <div class="float-right">
                                        @if (Auth::check() &&
                                                (Auth::user()->email == $reply->email ||
                                                    Auth::user()->hasRole('Admin') ||
                                                    Auth::user()->hasRole('Manajer Konten')))
                                            <form id="delete-reply-{{ $reply->id }}" method="post"
                                                action="{{ route('service-desk.reply.destroy', $reply->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" style="width: 35px; height: 35px;"
                                                    class="btn btn-sm btn-danger"
                                                    onclick="confirmDelete('{{ $reply->id }}')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                <!-- Tampilkan tombol edit hanya untuk pemilik balasan -->
                                                @if (Auth::user()->email == $reply->email)
                                                    <button type="button" style="width: 35px; height: 35px;"
                                                        class="btn btn-sm btn-info"
                                                        onclick="toggleEditForm('reply', {{ $reply->id }})">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                @endif
                                            </form>
                                        @endif
                                    </div>

                                    <!-- Edit Reply Form -->
                                    <form id="edit-reply-form-{{ $reply->id }}" method="post"
                                        action="{{ route('service-desk.reply.update', $reply->id) }}"
                                        style="display: none;">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <textarea class="form-control" name="reply" rows="3" required>{{ $reply->reply }}</textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Perbarui</button>
                                        <button type="button" class="btn btn-secondary"
                                            onclick="toggleEditForm('reply', {{ $reply->id }})">Batal</button>
                                    </form>

                                </div>
                            </div>
                        @endforeach
                    @endif

                    <hr>
                    <!-- Form untuk menambahkan balasan baru -->
                    <p style="font-weight: bold; font-size: 20px">Kolom Balasan</p>

                    <div class="mt-3">
                        <form method="post" action="{{ route('service-desk.reply.store', ['id' => $question->id]) }}">
                            @csrf
                            <div class="form-group">
                                <input type="email" name="email" class="form-control" placeholder="Email"
                                    value="{{ Auth::user()->email }}" readonly>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" name="reply" rows="1" placeholder="Balas disini..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>

                </div>
            </div>
        @endforeach

    </div>

    <!-- Pagination -->
    <div class="card-footer d-flex justify-content-center">
        {{ $questions->links('vendor.pagination.bootstrap-4') }}
    </div>

    <script>
        function confirmDeleteReply(replyId) {
            if (confirm('Are you sure you want to delete this reply?')) {
                document.getElementById('delete-reply-' + replyId).submit();
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const bantuButtons = document.querySelectorAll('.btn-bantu');
            const batalBantuButtons = document.querySelectorAll('.btn-batal-bantu');

            bantuButtons.forEach(button => {
                button.addEventListener("click", function(event) {
                    const questionId = button.getAttribute('data-question-id');
                    button.disabled = true;
                    axios.post('{{ route('service-desk.give-helpful') }}', {
                            question_id: questionId
                        })
                        .then(response => {
                            console.log(response.data);
                            location.reload();
                        })
                        .catch(error => {
                            console.error(error);
                        });
                });
            });

            batalBantuButtons.forEach(button => {
                button.addEventListener("click", function(event) {
                    const questionId = button.getAttribute('data-question-id');
                    button.disabled = true;
                    axios.post('{{ route('service-desk.remove-helpful') }}', {
                            question_id: questionId
                        })
                        .then(response => {
                            console.log(response.data);
                            location.reload();
                        })
                        .catch(error => {
                            console.error(error);
                        });
                });
            });
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        function confirmDeleteQuestion(questionId) {
            if (confirm('Apakah anda akan menghapus pertanyaan ini?')) {
                document.getElementById('delete-question-' + questionId).submit();
            }
        }

        function toggleEditForm(type, id) {
            const editForm = document.getElementById(`edit-${type}-form-${id}`);
            if (editForm.style.display === 'none') {
                editForm.style.display = 'block';
            } else {
                editForm.style.display = 'none';
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("submitForm").addEventListener("click", function(event) {
                var nameInput = document.getElementById("name").value;
                if (nameInput.length > 100) {
                    event.preventDefault(); // Stop form submission
                    swal("Error!", "Nama maksimal berisi 100 karakter.", "error");
                }
            });
        });
    </script>
@endsection
