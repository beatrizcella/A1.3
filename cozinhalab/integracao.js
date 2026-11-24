function mostrarMensagem(elemento, texto, sucesso) {
    if (sucesso) {
        elemento.className = "alert alert-success mt-3";
    } else {
        elemento.className = "alert alert-danger mt-3";
    }

    elemento.textContent = texto;
}

function formatarData(data) {
    const partes = data.split("-");
    return partes[2] + "/" + partes[1] + "/" + partes[0];
}

function escaparHtml(texto) {
    return String(texto)
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#39;");
}

function carregarPosts() {
    const blog = document.getElementById("blog-posts");

    if (!blog) return;

    fetch("blog-listar.php")
        .then(resposta => resposta.json())
        .then(posts => {

            blog.innerHTML = "";

            posts.forEach(post => {

                const link = post.link_externo.startsWith("https://")
                    || post.link_externo.startsWith("http://")
                    ? post.link_externo : "#";

                blog.innerHTML += `
                    <div class="col-md-6">
                        <div class="card h-100">

                            <img src="${escaparHtml(post.imagem)}"
                                 class="card-img-top"
                                 alt="${escaparHtml(post.titulo)}"
                                 style="height:200px;object-fit:cover;">

                            <div class="card-body">
                                <h5>${escaparHtml(post.titulo)}</h5>

                                <p class="text-muted small">
                                    ${escaparHtml(post.autor)} |
                                    ${escaparHtml(formatarData(post.data_publicacao))}
                                </p>

                                <p>${escaparHtml(post.descricao)}</p>

                                <a href="${escaparHtml(link)}"
                                   target="_blank"
                                   rel="noopener noreferrer"
                                   class="btn btn-warning btn-sm">
                                    Ler Mais
                                </a>

                            </div>
                        </div>
                    </div>
                `;
            });

            if (posts.length === 0) {
                blog.innerHTML = "Nenhum post publicado.";
            }
        });
}

function configurarFormulario(idFormulario, idMensagem) {
    const formulario = document.getElementById(idFormulario);
    const mensagem = document.getElementById(idMensagem);

    if (!formulario) return;

    formulario.addEventListener("submit", function(evento) {

        evento.preventDefault();

        fetch(formulario.action, {
            method: "POST",
            body: new FormData(formulario)
        })

        .then(resposta => resposta.json())

        .then(dados => {

            mostrarMensagem(mensagem, dados.mensagem, dados.sucesso);

            if (dados.sucesso) {
                formulario.reset();
            }

        });
    });
}

document.addEventListener("DOMContentLoaded", function() {

    carregarPosts();

    configurarFormulario("formContato", "mensagem-contato");

    configurarFormulario("formOrcamento", "mensagem-orcamento");

    const modal = document.getElementById("modalOrcamento");

    if (modal && window.location.hash === "#modalOrcamento" && window.bootstrap) {
        new bootstrap.Modal(modal).show();
    }

});
