#!/usr/bin/env bash
# Blocks shell commands that can wipe or reset database data until the user approves.

input=$(cat)

if printf '%s' "$input" | grep -qiE 'migrate:(fresh|refresh|reset|rollback)|db:wipe|schema:drop'; then
  cat <<'EOF'
{
  "permission": "ask",
  "user_message": "This command can delete or reset database data. Approve only if you intend to wipe or roll back data.",
  "agent_message": "Destructive database command requires explicit user approval. Do not proceed without confirmation."
}
EOF
  exit 0
fi

if printf '%s' "$input" | grep -qiE 'TRUNCATE[[:space:]]+TABLE|DROP[[:space:]]+(TABLE|DATABASE)'; then
  cat <<'EOF'
{
  "permission": "ask",
  "user_message": "This SQL can permanently delete database tables or data. Approve only if intentional.",
  "agent_message": "Destructive SQL requires explicit user approval."
}
EOF
  exit 0
fi

echo '{ "permission": "allow" }'
exit 0
