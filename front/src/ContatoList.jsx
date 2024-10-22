import { useState } from "react";

const ContatoList = ({ contatos, setContatos, selectedPessoa }) => {
  const [descricao, setDescricao] = useState("");
  const [tipo, setTipo] = useState("true"); // Select para boolean (true/false como string)
  const [showAddForm, setShowAddForm] = useState(false);
  const [showEditForm, setShowEditForm] = useState(false);
  const [selectedContato, setSelectedContato] = useState(null);

  // Função para adicionar contato
  const handleAddContato = (e) => {
    e.preventDefault();
    const novoContato = {
      descricao,
      tipo: tipo === "true",
      idPessoa: selectedPessoa.id,
    };

    console.log(novoContato);

    fetch(`http://localhost:8000/contatos/${selectedPessoa.id}`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(novoContato),
    })
      .then((response) => response.json())
      .then((data) => {
        setContatos([...contatos, data]); // Atualiza a lista de contatos
        setDescricao("");
        setTipo("true"); // Reseta o campo de tipo para true
        setShowAddForm(false);
      })
      .catch((error) => console.error("Erro ao adicionar contato:", error));
  };

  // Função para editar contato
  const handleEditContato = (e) => {
    e.preventDefault();
    const updatedContato = { descricao, tipo: tipo === "true" };

    fetch(
      `http://localhost:8000/contatos/${selectedPessoa.id}/${selectedContato.id}`,
      {
        method: "PATCH",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(updatedContato),
      }
    )
      .then((response) => response.json())
      .then((data) => {
        setContatos(
          contatos.map((contato) => (contato.id === data.id ? data : contato))
        );
        setShowEditForm(false);
        setSelectedContato(null); // Limpa o contato selecionado
      })
      .catch((error) => console.error("Erro ao editar contato:", error));
  };

  // Função para excluir contato
  const handleDeleteContato = (id) => {
    fetch(`http://localhost:8000/contatos/${selectedPessoa.id}/${id}`, {
      method: "DELETE",
    })
      .then(() => {
        setContatos(contatos.filter((contato) => contato.id !== id));
      })
      .catch((error) => console.error("Erro ao excluir contato:", error));
  };

  return (
    <div className="w-1/2 p-4">
      {selectedPessoa ? (
        <>
          <div className="flex justify-between items-center mb-4">
            <h2 className="text-lg font-bold">
              Contatos de {selectedPessoa.nome}
            </h2>
            <button
              onClick={() => setShowAddForm(true)}
              className="bg-blue-500 text-white px-4 py-2 rounded"
            >
              Adicionar Contato
            </button>
          </div>

          {showAddForm && (
            <form onSubmit={handleAddContato} className="mb-4">
              <input
                type="text"
                placeholder="Descrição"
                value={descricao}
                onChange={(e) => setDescricao(e.target.value)}
                className="border px-2 py-1 mr-2"
                required
              />
              <select
                value={tipo}
                onChange={(e) => setTipo(e.target.value)}
                className="border px-2 py-1"
              >
                <option value="true">Ativo</option>
                <option value="false">Inativo</option>
              </select>
              <button
                type="submit"
                className="bg-green-500 text-white px-4 py-2 rounded ml-2"
              >
                Salvar
              </button>
            </form>
          )}

          {showEditForm && selectedContato && (
            <form onSubmit={handleEditContato} className="mb-4">
              <input
                type="text"
                placeholder="Descrição"
                value={descricao}
                onChange={(e) => setDescricao(e.target.value)}
                className="border px-2 py-1 mr-2"
                required
              />
              <select
                value={tipo}
                onChange={(e) => setTipo(e.target.value)}
                className="border px-2 py-1"
              >
                <option value="true">Ativo</option>
                <option value="false">Inativo</option>
              </select>
              <button
                type="submit"
                className="bg-green-500 text-white px-4 py-2 rounded ml-2"
              >
                Salvar
              </button>
            </form>
          )}

          <ul>
            {contatos.map((contato) => (
              <li
                key={contato.id}
                className="flex justify-between items-center mb-2"
              >
                <span>{contato.descricao}</span>
                <div>
                  <button
                    onClick={() => {
                      setSelectedContato(contato);
                      setDescricao(contato.descricao);
                      setTipo(contato.tipo ? "true" : "false");
                      setShowEditForm(true);
                    }}
                    className="bg-green-500 text-white px-2 py-1 mr-2"
                  >
                    Editar
                  </button>
                  <button
                    onClick={() => handleDeleteContato(contato.id)}
                    className="bg-red-500 text-white px-2 py-1"
                  >
                    Excluir
                  </button>
                </div>
              </li>
            ))}
          </ul>
        </>
      ) : (
        <p>Selecione uma pessoa para ver seus contatos.</p>
      )}
    </div>
  );
};

export default ContatoList;
