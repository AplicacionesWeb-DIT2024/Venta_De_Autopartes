import { useState, useEffect, useRef } from 'react';
import { useNavigate, useParams } from 'react-router-dom';
import api from "../api";
import './Editar.css'; // Importa el CSS para el formulario


export default function Editar() {

    const { id } = useParams();
    const navigate = useNavigate();

    const [fotos, setFotos] = useState([]);
    const [previewFotos, setPreviewFotos] = useState([]);
    const [existingFotos, setExistingFotos] = useState([]);
    const [loadedFotos, setLoadedFotos] = useState(new Set());

    const [formData, setFormData] = useState({
        nombre: "",
        marca: "",
        modelo: "",
        anio: "",
        codigo: "",
        estado: "",
        precio: "",
        color: "",
        stock: ""
    });

    const [loading, setLoading] = useState(true);
    const [saving, setSaving] = useState(false);
    const [error, setErrors] = useState({});


    const editedRef = useRef(false); // Marca si el usuario ya comenzó a editar el formulario

    const formatMiles = (valor) => {
        if (!valor) return "";
        const numero = Math.trunc(Number(valor));
        return numero.toLocaleString("es-AR");
    };

    const currentYear = new Date().getFullYear();

    const years = [];
    for (let year = currentYear; year >= 1930; year--) {
        years.push(year);
    }

    const handleChange = (e) => {

        const { name, value } = e.target;


        editedRef.current = true; // Marcar que el usuario editó el formulario para evitar que la carga inicial del servidor sobrescriba sus cambios.

        if (error[name]) {
            setErrors(prev => ({
                ...prev,
                [name]: ""
            }));
        }

        // Validación específica para el campo stock
        if (name === "stock") {

            if (value === "") { // Si el campo está vacío, no mostrar error y permitir que se borre el valor
                setErrors(prev => ({
                    ...prev,
                    stock: ""
                }));

                setFormData(prev => ({ // Permitir que el usuario borre el valor del stock sin mostrar error
                    ...prev,
                    [name]: ""
                }));

                return;
            }

            if (!/^\d+$/.test(value)) { // Validar que sea un número entero positivo
                setErrors(prev => ({
                    ...prev,
                    stock: "El stock debe ser un número entero positivo"
                }));

                return;
            }

            setErrors(prev => ({ // Si pasa la validación, limpiar el error
                ...prev,
                stock: ""
            }));
        }

        setFormData(prev => ({
            ...prev,
            [name]: value
        }));
    };


    useEffect(() => {
        // Cargo las caracteristicas de la autopif () {arte a modificar
        const cargarAutoparte = async () => {
            try {
                const response = await api.get(`/autoparts/${id}`);

                console.log(response.data)

                const autoparte = response.data;

                if (!editedRef.current) { // Solo establecer los valores iniciales si el usuario no empezó a editar el formulario aún.
                    setFormData({
                        nombre: autoparte.autoparte || "",
                        marca: autoparte.marca || "",
                        modelo: autoparte.modelo || "",
                        anio: autoparte.anioVehiculo || "",
                        codigo: autoparte.codigo || "",
                        estado: autoparte.estado || "",
                        precio: String(autoparte.precio || ""),
                        color: autoparte.color || "",
                        stock: autoparte.stock || ""
                    });
                    if (autoparte.foto) {
                        const fotosArray = Array.isArray(autoparte.foto) ? autoparte.foto : [autoparte.foto];
                        setPreviewFotos(fotosArray.map(f => `http://127.0.0.1:8000/storage/${f}`));
                        setExistingFotos(fotosArray);
                    }
                }
            } catch (error) {
                console.error("Error al cargar la autoparte:", error);
            } finally {
                setLoading(false);
            }
        };


        editedRef.current = false; // Resetear la marca de edición al cambiar de id (nueva carga)

        cargarAutoparte();
    }, [id]);

    // Manejo exclusivo de la foto
    const handleFotoChange = (e) => {
        const archivos = Array.from(e.target.files);

        if (fotos.length + archivos.length > 7) {
            setErrors(prev => ({
                ...prev,
                foto: "Máximo 7 fotos permitidas"
            }));
            return;
        }

        const tiposPermitidos = [
            "image/jpeg", "image/png", "image/jpg", "image/webp"
        ];

        for (const archivo of archivos) {
            if (!tiposPermitidos.includes(archivo.type)) {
                setErrors(prev => ({
                    ...prev,
                    foto: "La imagen debe ser JPG, JPEG, PNG O WEBP."
                }));
                return;
            }
            if (archivo.size > 5 * 1024 * 1024) {
                setErrors(prev => ({
                    ...prev,
                    foto: "La imagen no debe superar los 5 MB."
                }));
                return;
            }
        }

        const nuevasFotos = [...fotos, ...archivos];
        const nuevasPreviews = [...previewFotos, ...archivos.map(a => URL.createObjectURL(a))];

        setFotos(nuevasFotos);
        setPreviewFotos(nuevasPreviews);
        setErrors(prev => ({ ...prev, foto: "" }));
    };

    const removeFoto = (index) => {
        const total = existingFotos.length + fotos.length;
        if (index < existingFotos.length) {
            setExistingFotos(prev => prev.filter((_, i) => i !== index));
        } else {
            const newIndex = index - existingFotos.length;
            URL.revokeObjectURL(previewFotos[index]);
            setFotos(prev => prev.filter((_, i) => i !== newIndex));
        }
        setPreviewFotos(prev => prev.filter((_, i) => i !== index));
    };


    const handleSubmit = async (e) => {

        e.preventDefault();

        let nuevosErrores = {};

        const nombreCampos = {
            nombre: "Nombre",
            marca: "Marca",
            modelo: "Modelo",
            anio: "Año",
            codigo: "Código",
            estado: "Estado",
            precio: "Precio",
            color: "Color",
            stock: "Stock"
        };

        /* Mensajes de Error */
        Object.entries(formData).forEach(([campo, valor]) => {
            if (valor === "") {
                nuevosErrores[campo] =
                    `El campo ${nombreCampos[campo]} es obligatorio`;
            }
        });

        const precioNum = Number(formData.precio);
        const stockNum = Number(formData.stock); // Convertir el valor del stock a número
        if (
            formData.precio &&
            (isNaN(precioNum) ||
                precioNum < 1 ||
                precioNum > 5000000)
        ) {

            nuevosErrores.precio =
                "Ingrese un precio entre $1 y 5.000.000";

        }

        if (
            formData.stock &&
            (stockNum < 1 || stockNum > 99)
        ) {
            nuevosErrores.stock =
                "El stock debe ser un número entero entre 1 y 99";
        }

        if (Object.keys(nuevosErrores).length > 0) {
            setErrors(nuevosErrores);
            return;

        }

        if (fotos.length === 0 && existingFotos.length === 0) {
            setErrors({ foto: "Debe tener al menos una foto" });
            return;
        }

        try {
            setSaving(true);

            //Crear FormData para enviar datos + foto
            const datos = new FormData();
            datos.append("_method", "PUT")
            datos.append("autoparte", formData.nombre);
            datos.append("marca", formData.marca);
            datos.append("modelo", formData.modelo);
            datos.append("anioVehiculo", formData.anio);
            datos.append("codigo", formData.codigo);
            datos.append("estado", formData.estado);
            datos.append("precio", Number(formData.precio));
            datos.append("color", formData.color);
            datos.append("stock", formData.stock);
            fotos.forEach(f => datos.append("foto[]", f)); // La foto es obligatoria
            existingFotos.forEach(f => datos.append("existing_foto[]", f));

            await api.post(`/autoparts/${id}`, datos, {
                headers: { "Content-Type": "multipart/form-data" }
            });

            navigate("/autoparts");
        } catch (error) {

            const backendErrors = error.response?.data?.errors;

            if (backendErrors?.codigo) {

                setErrors(prev => ({
                    ...prev,
                    codigo: "Este código ya se utilizó"
                }));

            }

            if (backendErrors?.precio) {

                setErrors(prev => ({
                    ...prev,
                    precio: backendErrors.precio[0]
                }));

            }
        } finally {
            setSaving(false);
        }
    }

    if (loading) {
        return (
            <div className="d-flex flex-column justify-content-center align-items-center vh-100">
                <div
                    className="spinner-border"
                    style={{ width: "4rem", height: "4rem" }}
                    role="status"
                >
                    <span className="visually-hidden">
                        Cargando...
                    </span>
                </div>

                <p className="mt-3 fs-5">
                    Cargando autoparte...
                </p>
            </div>


        )
    }

    return (
        <div className="editar-container">
            <h2>
                Editar Autoparte
            </h2>

            <form onSubmit={handleSubmit} className="editar-form">

                <label>Nombre</label>
                <input
                    type="text"
                    name="nombre"
                    value={formData.nombre}
                    onChange={handleChange}
                    placeholder="Nombre"
                    className="form-control mb-3"
                />
                {error.nombre && (
                    <small className="text-danger">
                        {error.nombre}
                    </small>
                )}

                <label>Marca</label>
                <input
                    type="text"
                    name="marca"
                    value={formData.marca}
                    onChange={handleChange}
                    placeholder="Marca"
                    className="form-control mb-3"
                />
                {error.marca && (
                    <small className="text-danger">
                        {error.marca}
                    </small>
                )}

                <label>Modelo</label>
                <input
                    type="text"
                    name="modelo"
                    value={formData.modelo}
                    onChange={handleChange}
                    placeholder="Modelo"
                    className="form-control mb-3"
                />
                {error.modelo && (
                    <small className="text-danger">
                        {error.modelo}
                    </small>
                )}

                <label>Año</label>
                <select
                    name="anio"
                    value={formData.anio}
                    onChange={handleChange}
                >
                    <option value="">Seleccione un año</option>
                    {years.map((year) => (
                        <option key={year} value={year}>
                            {year}
                        </option>
                    ))}
                </select>
                {error.anio && (
                    <small className="text-danger">
                        {error.anio}
                    </small>
                )}

                <label>Código</label>
                <input
                    type="text"
                    name="codigo"
                    value={formData.codigo}
                    onChange={handleChange}
                    placeholder="Código"
                    className="form-control mb-3"
                />
                {error.codigo && (
                    <small className="text-danger">
                        {error.codigo}
                    </small>
                )}

                <label>Estado</label>
                <select
                    name="estado"
                    value={formData.estado}
                    onChange={handleChange}>
                    <option value="">Seleccione un estado</option>
                    <option value="Muy Bueno">Muy Bueno</option>
                    <option value="Bueno">Bueno</option>
                    <option value="Regular">Regular</option>
                    <option value="Malo">Malo</option>
                    <option value="Muy Malo">Muy Malo</option>
                </select>
                {error.estado && (
                    <small className="text-danger">
                        {error.estado}
                    </small>
                )}

                <label>Precio</label>
                <input
                    type="text"
                    name="precio"
                    value={formatMiles(formData.precio)}
                    onChange={(e) => {
                        const limpio = e.target.value.replace(/\D/g, "");
                        handleChange({
                            target: {
                                name: "precio",
                                value: limpio
                            }
                        });
                        if (error.precio) {
                            setErrors(prev => ({
                                ...prev,
                                precio: ""
                            }));
                        }
                    }}
                    placeholder="Precio"
                    className="form-control mb-3"
                />
                {error.precio && (
                    <small className="text-danger">
                        {error.precio}
                    </small>
                )}

                <label>Color</label>
                <input
                    type="text"
                    name="color"
                    value={formData.color}
                    onChange={handleChange}
                    placeholder="Color"
                    className="form-control mb-3"
                />
                {error.color && (
                    <small className="text-danger">
                        {error.color}
                    </small>
                )}

                <label>Stock</label>
                <input
                    type="text"
                    name="stock"
                    value={formData.stock}
                    onChange={handleChange}
                    placeholder="Stock"
                    className="form-control mb-3"
                />
                {error.stock && (
                    <small className="text-danger">
                        {error.stock}
                    </small>
                )}

                <label>Foto de la autoparte</label>
                <div className="foto-container">
                    {previewFotos.length > 0 && (
                        <div className="fotos-grid">
                            {previewFotos.map((src, index) => (
                                <div key={index} className="foto-preview imagen-wrapper">
                                    <img
                                        src={src}
                                        alt={`Foto ${index + 1}`}
                                        onLoad={() => setLoadedFotos(prev => new Set(prev).add(index))}
                                    />
                                    {!loadedFotos.has(index) && (
                                        <div className="text-muted py-3">Cargando imagen...</div>
                                    )}
                                    <button
                                        type="button"
                                        className="foto-remove"
                                        onClick={() => removeFoto(index)}
                                    >
                                        x
                                    </button>
                                </div>
                            ))}
                        </div>
                    )}
                    {previewFotos.length === 0 && (
                        <div className="foto-placeholder">
                            <p> Selecciona las fotos de la autoparte (máximo 7)</p>
                        </div>
                    )}

                    < input
                        id="foto"
                        type="file"
                        name="foto"
                        accept="image/jpeg,image/png,image/jpg,image/webp"
                        multiple
                        onChange={handleFotoChange}
                    />

                    <small className="foto-ayuda">
                        JPG, JPEG, PNG O WEBP. Máximo 5MB.
                    </small>

                </div>
                {error.foto && (
                    <small className="text-danger">{error.foto}</small>
                )}

                <button
                    type="submit"
                    disabled={saving}
                    className={`d-flex justify-content-center align-items-center gap-2 ${saving ? "btn-disabled" : ""}`}
                >
                    {saving ? (
                        <>
                            <span
                                className="spinner-border spinner-border-sm"
                                role="status"
                                aria-hidden="true"
                            ></span>
                            Editando...
                        </>
                    ) : (
                        "Guardar Cambios"
                    )}
                </button>

                {/*Botón rojo para volver a la lista de autopartes */}
                <button
                    type="button"
                    onClick={() => navigate("/autoparts")}
                    disabled={saving}
                    className={`volver-button ${saving ? "btn-disabled" : ""}`}
                >
                    Volver
                </button>
            </form>
        </div>
    )
};
