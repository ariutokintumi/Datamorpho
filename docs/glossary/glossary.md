# **Datamorpho Glossary**

**Base File**  
 The original visible file used as the carrier input before Datamorpho embedding.

**Carrier File**  
 The final Datamorphed file.

**Carrier Profile**  
 The file-family-specific embedding rules, such as `jpeg-trailer`, `txt-envelope`, or `pdf-incremental`.

**Chaff**  
 Bytes intentionally present in a payload region but not used by the target hidden state, added to increase ambiguity and attack cost.

**Concealed Payload**  
 The payload bytes from which one or more hidden states can be reconstructed.

**Datamorphed File**  
 A file that conforms to a Datamorpho carrier profile and contains a public manifest plus concealed payload data.

**Datamorphosis**  
 The capability of a file to contain one or more hidden states beyond its visible representation.

**Fragment**  
 A span of bytes referenced by a reconstruction object as part of one hidden state.

**Hidden State**  
 A concealed alternate content state associated with a Datamorphed file.

**Layout Strategy**  
 The arrangement model for meaningful bytes in a payload region. In v0.001: `sparse` or `sparse-with-chaff`.

**MorphoStorage**  
 A locator or direction layer describing where to look for the reconstruction object of a state.

**Public Manifest**  
 The intentionally visible metadata declaring Datamorphosis, states, triggers, MorphoStorage, and reconstruction-object digests.

**Reconstruction Object**  
 A state-specific secret-bearing artifact containing the instructions and secret material needed to reconstruct one hidden state.

**Sparse**  
 A layout strategy in which meaningful bytes are non-contiguous and only referenced spans matter.

**Sparse-with-Chaff**  
 A layout strategy in which meaningful bytes are non-contiguous and unreferenced bytes are intentionally present to increase ambiguity.

**Trigger**  
 A declared condition associated with a hidden state, such as time, event, action, ownership, or custom logic.