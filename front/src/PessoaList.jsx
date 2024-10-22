import { useEffect, useState } from "react";

const PessoaList = ({ onSelectPessoa }) => {
  const [pessoas, setPessoas] = useState([]);
  const [showAddForm, setShowAddForm] = useState(false);
  const [nome, setNome] = useState("");
  const [cpf, setCpf] = useState("");
  const [showEditForm, setShowEditForm] = useState(false);
  const [selectedPessoa, setSelectedPessoa] = useState(null);

  useEffect(() => {
    fetch("http://localhost:8000/pessoas")
      .then((response) => response.json())
      .then((data) => setPessoas(data));
  }, []);

  const handleAddPessoa = (e) => {
    e.preventDefault();
    const novaPessoa = { nome, cpf };

    fetch("http://localhost:8000/pessoas", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(novaPessoa),
    })
      .then((response) => response.json())
      .then((data) => {
        setPessoas([...pessoas, data]);
        setNome("");
        setCpf("");
        setShowAddForm(false);
      });
  };

  const handleDeletePessoa = (id) => {
    fetch(`http://localhost:8000/pessoas/${id}`, {
      method: "DELETE",
    }).then(() => {
      setPessoas(pessoas.filter((pessoa) => pessoa.id !== id));
    });
  };

  const handleEditPessoa = (e) => {
    e.preventDefault();
    const updatedPessoa = { nome, cpf };

    fetch(`http://localhost:8000/pessoas/${selectedPessoa.id}`, {
      method: "PUT",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(updatedPessoa),
    })
      .then((response) => response.json())
      .then((data) => {
        setPessoas(
          pessoas.map((pessoa) => (pessoa.id === data.id ? data : pessoa))
        );
        setShowEditForm(false);
      });
  };

  return (
    <div className="w-1/2 p-4">
      <div className="flex justify-between items-center mb-4">
        <h2 className="text-lg font-bold">Pessoas</h2>
        <button
          onClick={() => setShowAddForm(true)}
          className="bg-blue-500 text-white px-4 py-2 rounded"
        >
          Adicionar Pessoa
        </button>
      </div>

      {showAddForm && (
        <form onSubmit={handleAddPessoa} className="mb-4">
          <input
            type="text"
            placeholder="Nome"
            value={nome}
            onChange={(e) => setNome(e.target.value)}
            className="border px-2 py-1 mr-2"
            required
          />
          <input
            type="text"
            placeholder="CPF"
            value={cpf}
            onChange={(e) => setCpf(e.target.value)}
            className="border px-2 py-1"
            required
          />
          <button
            type="submit"
            className="bg-green-500 text-white px-4 py-2 rounded ml-2"
          >
            Salvar
          </button>
        </form>
      )}

      {showEditForm && (
        <form onSubmit={handleEditPessoa} className="mb-4">
          <input
            type="text"
            placeholder="Nome"
            value={nome}
            onChange={(e) => setNome(e.target.value)}
            className="border px-2 py-1 mr-2"
            required
          />
          <input
            type="text"
            placeholder="CPF"
            value={cpf}
            onChange={(e) => setCpf(e.target.value)}
            className="border px-2 py-1"
            required
          />
          <button
            type="submit"
            className="bg-green-500 text-white px-4 py-2 rounded ml-2"
          >
            Salvar
          </button>
        </form>
      )}

      <ul>
        {pessoas.map((pessoa) => (
          <li
            key={pessoa.id}
            className="flex justify-between items-center mb-2"
          >
            <span>{pessoa.nome}</span>
            <div>
              <button
                onClick={() => onSelectPessoa(pessoa)}
                className="bg-gray-200 px-2 py-1 mr-2"
              >
                Visualizar Contatos
              </button>
              <button
                onClick={() => {
                  setSelectedPessoa(pessoa);
                  setNome(pessoa.nome);
                  setCpf(pessoa.cpf);
                  setShowEditForm(true);
                }}
                className="bg-green-500 text-white px-2 py-1 mr-2"
              >
                Editar
              </button>
              <button
                onClick={() => handleDeletePessoa(pessoa.id)}
                className="bg-red-500 text-white px-2 py-1"
              >
                Excluir
              </button>
            </div>
          </li>
        ))}
      </ul>
    </div>
  );
};

export default PessoaList;
