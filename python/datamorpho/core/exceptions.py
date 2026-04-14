from __future__ import annotations


class DatamorphoError(Exception):
    """Base error for the Datamorpho reference implementation."""


class ValidationError(DatamorphoError):
    """Raised when an input or configuration is invalid."""


class CarrierError(DatamorphoError):
    """Raised when a carrier file cannot be parsed or safely processed."""


class ReconstructionError(DatamorphoError):
    """Raised when a hidden state cannot be reconstructed."""
